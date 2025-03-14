<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'User') {
            // If the user role is 'user', filter incidents where report_by = user's ID
            $incidents = Incident::where('reported_by', $user->id)->get();
        } else {
            // If the user is an admin or any other role, fetch all incidents
            $incidents = Incident::all();
        }

        return view('incidents.index', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incidents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'incident_type' => 'required|string|max:255',
            'description' => 'required|string',
            'media_type' => 'required|in:image,video',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480', // 20MB max
            'location' => 'required|string',
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('incidents', 'public');
        }

        $incident = Incident::create([
            'incident_type' => $request->incident_type,
            'description' => $request->description,
            'media_type' => $request->media_type,
            'media_path' => $mediaPath,
            'location' => $request->location,
            'reported_by' => auth()->id(),
        ]);

        return redirect()->route('incident.index')->with('success', 'Incident logged successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        return view('incidents.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        return view('incidents.edit', compact('incident'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        $request->validate([
            'incident_type' => 'required|string|max:255',
            'description' => 'required|string',
            'media_type' => 'required|in:image,video',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
            'location' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($request->hasFile('media')) {
            if ($incident->media_path) {
                Storage::disk('public')->delete($incident->media_path);
            }
            $incident->media_path = $request->file('media')->store('incidents', 'public');
        }

        $incident->update([
            'incident_type' => $request->incident_type,
            'description' => $request->description,
            'media_type' => $request->media_type,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return redirect()->route('incident.index')->with('success', 'Incident updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        if ($incident->media_path) {
            Storage::disk('public')->delete($incident->media_path);
        }
        $incident->delete();

        return redirect()->route('incident.index')->with('success', 'Incident deleted successfully.');
    }


}


