<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InterviewSlot;
use App\Models\ScholarshipRequirement;
use App\Models\ScholarshipStatus;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        // Fetch all scholarships with user relation
        $scholarships = Scholarship::with('user')
            ->whereNotNull('scholarship_status')
            ->where('user_id', '!=', 999)
            ->get();

        // Fetch the interview slot details
        $interviewSlot = InterviewSlot::first();
        $totalSlots = $interviewSlot?->total_slots ?? 100; // Default to 10 if not set

        // Count the number of scholarships with interview status as "interview_scheduled"
        $usedSlots = Scholarship::where('scholarship_status', 'interview_scheduled')->count();

        // Calculate available slots ensuring it never goes negative
        $availableSlots = max($totalSlots - $usedSlots, 0);

        return view('scholarship.admin', compact('scholarships', 'totalSlots', 'availableSlots', 'usedSlots'));
    }



    public function users()
    {
        $userId = auth()->id();
        $hasApplied = Scholarship::where('user_id', $userId)->first();
        $requirements = ScholarshipRequirement::all(); // Fetch all requirements

        // Fetch the scholarship status (default to 'closed' if no record is found)
        $scholarshipStatus = ScholarshipStatus::first()?->status ?? 'closed';

        return view('scholarship.users', compact('hasApplied', 'requirements', 'scholarshipStatus'));
    }





    public function index()
    {
        // Fetch total interview slots (from database)
        $totalSlots = InterviewSlot::first()?->total_slots ?? 10;

        // Count used slots
        $usedSlots = Scholarship::where('scholarship_status', 'interview_scheduled')->count();

        // Calculate available slots
        $availableSlots = max($totalSlots - $usedSlots, 0); // Prevent negative values

        $scholarships = Scholarship::with('user')->get();

        return view('admin.scholarships.index', compact('scholarships', 'totalSlots', 'availableSlots'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('scholarship.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScholarshipRequest $request)
    {
        return view('scholarship.store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Scholarship $scholarship)
    {
        return view('scholarship.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scholarship $scholarship)
    {
        return view('scholarship.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        return view('scholarship.update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        return view('scholarship.destroy');
    }

    public function apply(Request $request)
    {
        // Validate document link
        $request->validate([
            'document_link' => 'required|url',
        ]);

        $userId = auth()->id();

        // Check if the user already has a scholarship entry
        $scholarship = Scholarship::where('user_id', $userId)->first();

        if ($scholarship) {
            // Update existing record
            $scholarship->update([
                'scholarship_status' => 'applied',
                'document_link' => $request->document_link,
                'application_date' => $scholarship->application_date ?? now(),
            ]);
        } else {
            // Create a new record
            Scholarship::create([
                'user_id' => $userId,
                'scholarship_status' => 'applied',
                'document_link' => $request->document_link,
                'application_date' => now(),
            ]);
        }

        return back()->with('success', 'Application submitted successfully!');
    }

    public function approve($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update([
            'scholarship_status' => 'approved',
            'application_date' => $scholarship->application_date ?? now(), // Ensure application_date is set
        ]);

        return back()->with('success', 'Scholarship approved successfully!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update([
            'scholarship_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'application_date' => $scholarship->application_date ?? now(), // Ensure application_date is set
        ]);

        return back();
    }

    public function schedule(Request $request, $id)
    {
        $request->validate([
            'interview_date' => 'required|date|after_or_equal:today',
            'interview_time' => 'required',
            'interview_location' => 'required|string',
        ]);

        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update([
            'interview_date' => $request->interview_date,
            'interview_time' => $request->interview_time,
            'interview_location' => $request->interview_location,
            'scholarship_status' => 'interview_scheduled',
            'application_date' => $scholarship->application_date ?? now(), // Ensure application_date is set
        ]);

        return back()->with('success', 'Interview scheduled successfully!');
    }


    public function updateSlots(Request $request)
    {
        $request->validate([
            'total_slots' => 'required|integer|min:1',
        ]);

        $slot = InterviewSlot::first();
        if ($slot) {
            $slot->update(['total_slots' => $request->total_slots]);
        } else {
            InterviewSlot::create(['total_slots' => $request->total_slots]);
        }

        return redirect()->back()->with('success', 'Interview slots updated successfully.');
    }
}
