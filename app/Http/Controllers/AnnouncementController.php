<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:500',
        ]);

        try {
            Announcement::create([
                'title' => $request->title,
                'message' => $request->message,
            ]);

            return redirect()->back()->with('success', 'Announcement added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add announcement. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:500',
        ]);

        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->update([
                'title' => $request->title,
                'message' => $request->message,
            ]);

            return redirect()->back()->with('success', 'Announcement updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update announcement. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();

            return redirect()->back()->with('success', 'Announcement deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete announcement. Please try again.');
        }
    }
}
