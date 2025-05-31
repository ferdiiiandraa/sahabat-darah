<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('rs.notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function markRead(Notification $notification)
    {
        // Check if the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $notification->is_read = true;
        $notification->save();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
