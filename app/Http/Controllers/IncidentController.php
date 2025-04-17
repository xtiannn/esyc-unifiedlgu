<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // If the user role is 'User', filter incidents where reported_by = user's ID
        // Eager load the reportedBy relationship to reduce queries
        $incidents = $user->role === 'User'
            ? Incident::with('reportedBy')->where('reported_by', $user->id)->get()
            : Incident::with('reportedBy')->get();

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
        \Log::info('Store method reached');

        // Validate input
        $validated = $request->validate([
            'incident_type' => 'required|string|max:255',
            'description' => 'required|string',
            'media_type' => 'required|in:image,video',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Handle media upload
        $mediaPath = null;
        if ($request->hasFile('media')) {
            // Store the file in the 'incidents' folder on the public disk
            $mediaPath = $request->file('media')->store('incidents', 'public');
        }



        // Create incident record
        $incident = Incident::create([
            'incident_type' => $validated['incident_type'],
            'description' => $validated['description'],
            'media_type' => $validated['media_type'],
            'media_path' => $mediaPath,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'reported_by' => Auth::user()->id,
            'contact_number' => Auth::user()->mobile,
        ]);

        // Send a notification to all users
        $this->sendNotificationToAllUsers($incident);

        return redirect()->route('incident.index')->with('success', 'Incident logged successfully.');
    }

    private function sendNotificationToAllUsers(Incident $incident)
    {
        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Create and save a new notification for each user
            Notification::create([
                'user_id' => $user->id,
                'incident_id' => $incident->id,
                'title' => 'New Incident Reported',
                'message' => "A new incident has been reported. Check it out!",
                'type' => 'incident',
                'is_read' => 0,
            ]);
        }

        \Log::info('Notifications sent to all users.');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $incident = Incident::with('reportedBy')->findOrFail($id);
        return response()->json($incident);
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
        // Validate input
        $validated = $request->validate([
            'incident_type' => 'required|string|max:255',
            'description' => 'required|string',
            'media_type' => 'required|in:image,video',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|string',
        ]);

        // Handle new media file upload (if any)
        if ($request->hasFile('media')) {
            // Delete the old media file if it exists
            if ($incident->media_path) {
                Storage::disk('public')->delete($incident->media_path);
            }

            // Store the new media file
            $incident->media_path = $request->file('media')->store('incidents', 'public');
        }

        // Update the incident record
        $incident->update([
            'incident_type' => $validated['incident_type'],
            'description' => $validated['description'],
            'media_type' => $validated['media_type'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('incident.index')->with('success', 'Incident updated successfully.');
    }
    public function updateStatus($id, Request $request)
    {
        // Validate the status
        $validated = $request->validate([
            'status' => ['required', 'in:pending,resolved,closed'],
        ]);

        try {
            // Find the incident by ID
            $incident = Incident::findOrFail($id);

            // Update the status
            $incident->status = $validated['status'];
            $incident->save();

            // Flash message to the session
            session()->flash('success', 'Incident status updated successfully!');

            // Return success response
            return response()->json([
                'incident' => $incident
            ], 200);
        } catch (\Exception $e) {
            // Flash error message
            session()->flash('error', 'Failed to update status. Please try again.');

            // Handle any errors
            return response()->json([
                'message' => 'Failed to update status. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        // Delete media file if it exists
        if ($incident->media_path) {
            Storage::disk('public')->delete($incident->media_path);
        }

        // Delete the incident record
        $incident->delete();

        return redirect()->route('incident.index')->with('success', 'Incident deleted successfully.');
    }
    public function getIncidentData($id)
    {
        $incident = Incident::with('reportedBy')->find($id);  // Fetch the incident by ID with the reported_by relationship

        if (!$incident) {
            return response()->json(['error' => 'Incident not found'], 404);
        }

        return response()->json($incident);
    }
}
