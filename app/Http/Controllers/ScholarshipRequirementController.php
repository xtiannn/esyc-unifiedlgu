<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipRequirement;
use App\Models\ScholarshipStatus;
use App\Models\ScholarshipBanner;
use Illuminate\Http\Request;

class ScholarshipRequirementController extends Controller
{
    public function index()
    {
        $requirements = ScholarshipRequirement::all();
        $totalRequirements = ScholarshipRequirement::count();
        $availableRequirements = ScholarshipRequirement::count();
        $scholarshipStatus = ScholarshipStatus::first();
        $banner = ScholarshipBanner::first();

        return view('scholarship.requirements', compact('requirements', 'totalRequirements', 'availableRequirements', 'scholarshipStatus', 'banner'));
    }

    public function showRequirements()
    {
        $requirements = ScholarshipRequirement::all();
        $totalRequirements = ScholarshipRequirement::count();
        $availableRequirements = ScholarshipRequirement::count();
        $scholarshipStatus = ScholarshipStatus::first();
        $banner = ScholarshipBanner::first();

        return view('scholarship.requirements', compact('requirements', 'totalRequirements', 'availableRequirements', 'scholarshipStatus', 'banner'));
    }

    public function showScholarship()
    {
        $requirements = ScholarshipRequirement::all();
        $scholarshipStatus = ScholarshipStatus::first();
        $banner = ScholarshipBanner::first();
        return view('scholarship.view', compact('requirements', 'scholarshipStatus', 'banner'));
    }

    public function store(Request $request)
    {
        $scholarshipStatus = ScholarshipStatus::first();
        if ($scholarshipStatus->status === 'closed') {
            return redirect()->route('requirements.index')->with('error', 'Cannot add requirements while scholarship application is closed.');
        }

        $validated = $request->validate([
            'requirement_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        ScholarshipRequirement::create([
            'name' => $validated['requirement_name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('requirements.index')->with('success', 'Requirement added successfully!');
    }

    public function edit(ScholarshipRequirement $requirement)
    {
        $scholarshipStatus = ScholarshipStatus::first();
        return view('scholarship.edit_requirement', compact('requirement', 'scholarshipStatus'));
    }

    public function update(Request $request, ScholarshipRequirement $requirement)
    {
        $scholarshipStatus = ScholarshipStatus::first();
        if ($scholarshipStatus->status === 'closed') {
            return redirect()->route('requirements.index')->with('error', 'Cannot update requirements while scholarship application is closed.');
        }

        $validated = $request->validate([
            'requirement_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $requirement->update([
            'name' => $validated['requirement_name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('requirements.index')->with('success', 'Requirement updated successfully!');
    }

    public function destroy(ScholarshipRequirement $requirement)
    {
        $scholarshipStatus = ScholarshipStatus::first();
        if ($scholarshipStatus->status === 'closed') {
            return redirect()->route('requirements.index')->with('error', 'Cannot delete requirements while scholarship application is closed.');
        }

        $requirement->delete();

        return redirect()->route('requirements.index')->with('success', 'Requirement deleted successfully!');
    }

    public function toggleScholarshipStatus(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,closed',
        ]);

        $scholarshipStatus = ScholarshipStatus::first();
        $scholarshipStatus->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('requirements.index')->with('success', 'Scholarship application status updated successfully!');
    }
}
