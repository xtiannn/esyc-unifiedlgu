<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AuditLog;
use App\Models\Cases;
use App\Models\Emergency;
use App\Models\Incident;
use App\Models\InterviewSlot;
use App\Models\Scholarship;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Spatie\Browsershot\Browsershot;

class DashboardController extends Controller
{
    public function admin()
    {
        // Resident statistics
        $totalResidents = User::count();
        $totalMale = User::where('sex', 'MALE')->count();
        $totalFemale = User::where('sex', 'FEMALE')->count();
        $workingResidents = User::where('working', 'yes')->count();

        // Cases statistics
        $totalCases = Cases::count();
        $totalOpenCases = Cases::where('status', 'open')->count();
        $totalInProgress = Cases::where('status', 'in_progress')->count();
        $totalResolved = Cases::where('status', 'resolved')->count();
        $caseTypes = Cases::groupBy('case_type')->selectRaw('case_type, COUNT(*) as count')->get();

        // Scholarship statistics
        $totalScholarshipApplications = Scholarship::count();
        $totalPendingScholarships = Scholarship::where('scholarship_status', 'applied')->count();
        $totalInterviewScheduled = Scholarship::where('scholarship_status', 'interview_scheduled')->count();
        $totalApprovedScholarships = Scholarship::where('scholarship_status', 'approved')->count();
        $totalRejectedScholarships = Scholarship::where('scholarship_status', 'rejected')->count();

        // Emergency alerts (recent 5)
        $recentEmergencies = Emergency::with('creator', 'case')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Incident statistics
        $totalIncidents = Incident::count();
        $pendingIncidents = Incident::where('status', 'pending')->count();
        $resolvedIncidents = Incident::where('status', 'resolved')->count();

        // Recent audit logs (recent 5)
        $recentAuditLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent announcements (recent 5)
        $recentAnnouncements = Announcement::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalResidents',
            'totalMale',
            'totalFemale',
            'workingResidents',
            'totalCases',
            'totalOpenCases',
            'totalInProgress',
            'totalResolved',
            'caseTypes',
            'totalScholarshipApplications',
            'totalPendingScholarships',
            'totalInterviewScheduled',
            'totalApprovedScholarships',
            'totalRejectedScholarships',
            'recentEmergencies',
            'totalIncidents',
            'pendingIncidents',
            'resolvedIncidents',
            'recentAuditLogs',
            'recentAnnouncements'
        ));
    }
    public function users()
    {
        $cases = Cases::all();
        $alerts = Emergency::all();
        return view('dashboard.users', compact('cases', 'alerts'));
    }

    public function generateReport(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'start_date' => [
                'required',
                'date',
                'after_or_equal:2000-01-01',
                'before_or_equal:today',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                'before_or_equal:today',
            ],
        ], [
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.after_or_equal' => 'The start date must be on or after January 1, 2000.',
            'start_date.before_or_equal' => 'The start date cannot be in the future.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
            'end_date.before_or_equal' => 'The end date cannot be in the future.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            flash()->error($errorMessages);
            return redirect()->back()->withInput();
        }

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Validate date range (max 1 year)
        if ($startDate->diffInDays($endDate) > 365) {
            flash()->error('The date range cannot exceed one year.');
            return redirect()->back()->withInput();
        }

        // Check for data existence
        $hasData = User::exists() ||
            Cases::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->exists() ||
            Emergency::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->exists() ||
            Incident::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->exists() ||
            Scholarship::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->exists() ||
            Announcement::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->exists();

        if (!$hasData) {
            flash()->error('No data available for the selected date range.');
            return redirect()->back()->withInput();
        }

        // Data for the report
        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalResidents' => User::count(),
            'totalMale' => User::where('sex', 'MALE')->count(),
            'totalFemale' => User::where('sex', 'FEMALE')->count(),
            'workingResidents' => User::where('working', 'yes')->count(),
            'totalCases' => Cases::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->count(),
            'openCases' => Cases::where('status', 'open')->whereBetween('created_at', [$startDate, $endDate->endOfDay()])->count(),
            'inProgressCases' => Cases::where('status', 'in_progress')->whereBetween('created_at', [$startDate, $endDate->endOfDay()])->count(),
            'resolvedCases' => Cases::where('status', 'resolved')->whereBetween('created_at', [$startDate, $endDate->endOfDay()])->count(),
            'caseTypes' => Cases::groupBy('case_type')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->selectRaw('case_type, COUNT(*) as count')
                ->get(),
            'emergencies' => Emergency::with('creator', 'case')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->orderBy('created_at', 'desc')
                ->get(),
            'totalIncidents' => Incident::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->count(),
            'pendingIncidents' => Incident::where('status', 'pending')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->count(),
            'resolvedIncidents' => Incident::where('status', 'resolved')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->count(),
            'totalScholarships' => Scholarship::whereBetween('created_at', [$startDate, $endDate->endOfDay()])->count(),
            'pendingScholarships' => Scholarship::where('scholarship_status', 'applied')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->count(),
            'interviewScheduledScholarships' => Scholarship::where('scholarship_status', 'interview_scheduled')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->count(),
            'approvedScholarships' => Scholarship::where('scholarship_status', 'approved')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->count(),
            'rejectedScholarships' => Scholarship::where('scholarship_status', 'rejected')
                ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->count(),
            'announcements' => Announcement::whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                ->orderBy('created_at', 'desc')
                ->get(),
            'residentsChartData' => [
                'labels' => ['Male', 'Female'],
                'data' => [User::where('sex', 'MALE')->count(), User::where('sex', 'FEMALE')->count()],
                'colors' => ['#2563eb', '#ef4444'],
            ],
            'casesChartData' => [
                'labels' => Cases::groupBy('case_type')
                    ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                    ->pluck('case_type')
                    ->toArray(),
                'data' => Cases::groupBy('case_type')
                    ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                    ->selectRaw('COUNT(*) as count')
                    ->pluck('count')
                    ->toArray(),
                'colors' => ['#2563eb', '#ef4444', '#f59e0b', '#10b981'],
            ],
        ];

        // Load PDF view
        $pdf = Pdf::loadView('reports.chairman', $data)
            ->setPaper('a4')
            ->setOption('enable-local-file-access', true)
            ->setOption('dpi', 150);

        // Flash success message
        // flash()->success('Report generated successfully!');

        return $pdf->download('chairman_report_' . date('Ymd') . '.pdf');
    }
}
