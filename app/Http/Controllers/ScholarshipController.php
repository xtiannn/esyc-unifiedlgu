<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;
use App\Models\User;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        // $availableSlots =
        $scholarships = Scholarship::with('user')->get();
        // return response()->json($scholarships);
        return view('scholarship.admin', compact('scholarships'));
    }
    public function users()
    {
        $hasApplied = false;
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
}
