<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        # Fetch total count in residents
        $totalResidents = User::count();
        $totalMale = User::where('gender', 'male')->count(); // male residents
        $totalFemale = User::where('gender', 'female')->count(); // female residents
        $totalSingle = User::where('civil_status', 'Single')->count();  // single residents

        #CASES COUNTS
        $totalCases = Cases::count();  // Total Cases
        $totalOpenCases = Cases::where('status', 'open')->count(); // open cases counts
        $totalInProgress = Cases::where('status', 'in_progress')->count(); // In-progress cases counts
        $totalResolved = Cases::where('status', 'resolved')->count(); // Resolved cases counts

        #SHOLARSHIP OVERVIEW
        $totalScholarshipApplications = Scholarship::count();  // Total Applications
        $totalPendingScholarships = Scholarship::where('scholarship_status', 'applied')->count();  // Total Pending Applications
        $totalApprovedScholarships = Scholarship::where('scholarship_status', 'approved')->count();  // Total Approved Applications
        $totalRejectedScholarships = Scholarship::where('scholarship_status', 'rejected')->count();  // Total Rejected Applications




        return view('dashboard.admin', compact(
            'totalResidents',
            'totalMale',
            'totalFemale',
            'totalSingle',
            'totalCases',
            'totalOpenCases',
            'totalInProgress',
            'totalResolved',
            'totalScholarshipApplications',
            'totalPendingScholarships',
            'totalApprovedScholarships',
            'totalRejectedScholarships'
        ));
    }

    public function users()
    {
        return view('dashboard.users');
    }

}
