<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Cases;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Flasher\Prime\FlasherInterface;

class CasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $cases = Cases::all();
        return view('cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'case_title' => 'required|string|max:255',
                'case_type' => 'required|string',
                'guardian_name' => 'required|string|max:255',
                'guardian_contact' => 'required|string|max:255',
                'notes' => 'nullable|string|max:255',
            ]);

            $case = Cases::create([
                'case_title' => $validated['case_title'],
                'case_type' => $validated['case_type'],
                'guardian_name' => $validated['guardian_name'],
                'guardian_contact' => $validated['guardian_contact'],
                'notes' => $validated['notes'],
                'created_by' => Auth::id(),
            ]);

            // Log creation
            AuditHelper::log(
                "Created a new case (ID: $case->id, Title: {$case->case_title})",
                'Created',
                'Cases',
                $case->id,
                null,
                $case->toArray()
            );

            return redirect()->route('cases.index')->with('success', 'Case created successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to create case: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Cases $cases)
    {
        return view('cases.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cases $cases)
    {
        return view('cases.edit');
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Cases $case)
    {
        try {
            $validated = $request->validate([
                'case_title' => 'required|string|max:255',
                'case_type' => 'required|string',
                'guardian_name' => 'required|string|min:1|max:255',
                'guardian_contact' => 'required|string|min:1|max:11',
                'notes' => 'nullable|string|min:1|max:255',
                'status' => ['required', Rule::in(['open', 'closed', 'in_progress', 'resolved'])],
            ]);

            $oldValues = $case->getOriginal(); // Get old values before updating

            $case->update($validated);

            // Log update
            AuditHelper::log(
                "Updated case (ID: $case->id, Title: {$case->case_title})",
                'Updated',
                'Cases',
                $case->id,
                $oldValues,
                $case->toArray()
            );

            return redirect()->route('cases.index')->with('success', 'Case updated successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to update case: ' . $e->getMessage()]);
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cases $case)
    {
        try {
            $oldValues = $case->toArray(); // Get values before deleting

            $case->delete();

            // Log deletion
            AuditHelper::log(
                "Deleted case (ID: $case->id, Title: {$oldValues['case_title']})",
                'Deleted',
                'Cases',
                $case->id,
                $oldValues,
                null
            );

            return redirect()->route('cases.index')->with('success', 'Case deleted successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete case: ' . $e->getMessage()]);
        }
    }

}
