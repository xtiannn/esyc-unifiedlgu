<?php

namespace App\Http\Controllers;

use App\Models\Emergency;
use App\Http\Requests\StoreEmergencyRequest;
use App\Http\Requests\UpdateEmergencyRequest;
use Illuminate\Http\Request;
use Auth;
use Exception;
// use Request;

class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Emergency::query();

        // If the user is a "user", filter by reported_by
        if (Auth::user()->role === 'User') {
            $query->where('created_by', Auth::id());
        }

        $emergencies = $query->get();

        return view('emergency.index', compact('emergencies'));
    }

    public function incidents()
    {
        return view('emergency.incidents');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emergency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
        ]);

        // Initialize default values
        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('emergencies', 'public');

            // Determine media type based on ENUM values
            $imageExtensions = ['jpg', 'jpeg', 'png'];
            $videoExtensions = ['mp4', 'mov', 'avi'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, $imageExtensions)) {
                $mediaType = 'image';
            } elseif (in_array($extension, $videoExtensions)) {
                $mediaType = 'video';
            } else {
                return redirect()->back()->withErrors(['media' => 'Invalid media type.']);
            }
        }

        // Create a new emergency alert
        Emergency::create([
            'title' => $request->title,
            'message' => $request->message,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'created_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Emergency alert sent successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Emergency $emergency)
    {
        return view('emergency.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Emergency $emergency)
    {
        return view('emergency.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmergencyRequest $request, Emergency $emergency)
    {
        return view('emergency.update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emergency $emergency)
    {
        return view('emergency.destroy');
    }
}
