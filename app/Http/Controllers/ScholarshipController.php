<?php

namespace App\Http\Controllers;
use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        $scholarships = Scholarship::with('user')->get();
        return view('scholarship.admin', compact('scholarships'));
    }

    public function users()
    {
        $userId = auth()->id();
        $hasApplied = Scholarship::where('user_id', $userId)->first();
        return view('scholarship.users', compact('hasApplied'));
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
            ]);
        } else {
            // Create a new record
            Scholarship::create([
                'user_id' => $userId,
                'scholarship_status' => 'applied',
                'document_link' => $request->document_link,
            ]);
        }

        return back()->with('success', 'Application submitted successfully!');
    }

    public function approve($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update(['scholarship_status' => 'approved']);

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
            'rejection_reason' => $request->rejection_reason, // Store the reason
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
        ]);

        return back()->with('success', 'Interview scheduled successfully!');
    }


}
