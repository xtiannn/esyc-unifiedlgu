<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a list of all notifications for the authenticated user.
     */
    public function index()
    {
        $notifications = Notification::all();  // Fetch all notifications
        return view('notifications.index', compact('notifications'));  // Pass notifications to the view
    }

    /**
     * Optional: Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return redirect()->route('notifications.index')->with('success', 'All notifications marked as read.');
    }

    /**
     * Optional: Show a specific notification (if you want to expand later).
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        // Optional: Mark as read when viewed
        if (! $notification->is_read) {
            $notification->is_read = 1;
            $notification->save();
        }

        return response()->json($notification);
    }

    public function getDetails($id)
    {
        $notification = Notification::with(['incident.reportedBy'])->findOrFail($id);

        return response()->json([
            'id' => $notification->id,
            'title' => $notification->title,
            'message' => $notification->incident ? $notification->incident->description : $notification->message,
            'incident_type' => $notification->incident ? $notification->incident->type : 'N/A',
            'type' => $notification->type,
            'status' => $notification->incident ? $notification->incident->status : 'Pending',
            'latitude' => $notification->incident ? $notification->incident->latitude : null,
            'longitude' => $notification->incident ? $notification->incident->longitude : null,
            'created_at' => $notification->incident ? $notification->incident->created_at : $notification->created_at,
            'contact_number' => $notification->incident ? $notification->incident->contact_number : 'N/A',
            'reported_by' => $notification->incident && $notification->incident->reportedBy ? [
                'first_name' => $notification->incident->reportedBy->first_name ?? '',
                'middle_name' => $notification->incident->reportedBy->middle_name ?? '',
                'last_name' => $notification->incident->reportedBy->last_name ?? '',
            ] : null,
        ]);
    }

    public function fetch()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->where('is_read', 0)
            ->latest()
            ->take(10)
            ->get();

        return response()->json($notifications);
    }
    public function markAsRead($id)
    {
        \Log::info("Marking notification {$id} as read.");

        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->is_read = 1;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }
}
