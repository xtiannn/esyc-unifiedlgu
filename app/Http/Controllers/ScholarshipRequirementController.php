<?php
// app\Http\Controllers\ScholarshipRequirementController.php
namespace App\Http\Controllers;

use App\Models\ScholarshipRequirement;
use Illuminate\Http\Request;

class ScholarshipRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all requirements
        $requirements = ScholarshipRequirement::all();

        // Get total number of requirements
        $totalRequirements = ScholarshipRequirement::count();

        // Get available requirements (if any filtering is needed)
        $availableRequirements = ScholarshipRequirement::count();

        // Pass the variables to the view
        return view('scholarship.requirements', compact('requirements', 'totalRequirements', 'availableRequirements'));
    }



    public function showRequirements()
    {
        // Get all requirements
        $requirements = ScholarshipRequirement::all();

        // Get total number of requirements
        $totalRequirements = ScholarshipRequirement::count();

        // Get available requirements (if any filtering is needed)
        $availableRequirements = ScholarshipRequirement::count();

        // Pass the variables to the view
        return view('scholarship.requirements', compact('requirements', 'totalRequirements', 'availableRequirements'));
    }

    public function showScholarship()
    {
        $requirements = ScholarshipRequirement::all();  // Or however you're fetching the requirements
        return view('scholarship.view', compact('requirements'));
    }


    // Store a new scholarship requirement
    public function store(Request $request)
    {
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

    // Show the edit form for a specific requirement
    public function edit(ScholarshipRequirement $requirement)
    {
        return view('scholarship.edit_requirement', compact('requirement'));
    }

    // Update an existing scholarship requirement
    public function update(Request $request, ScholarshipRequirement $requirement)
    {
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

    // Delete a scholarship requirement
    public function destroy(ScholarshipRequirement $requirement)
    {
        $requirement->delete();

        return redirect()->route('requirements.index')->with('success', 'Requirement deleted successfully!');
    }
}
