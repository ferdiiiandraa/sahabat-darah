<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('rs.notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca');
    }

    public function markAllRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }
}
