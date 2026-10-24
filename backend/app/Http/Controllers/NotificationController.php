<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function show(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update([
            'read' => true,
        ]);

        return redirect($notification->url);
    }

    public function index()
    {
        $notifications = auth()
            ->user()
            ->notifications()
            ->paginate(15);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function markAllAsRead()
    {
        auth()
            ->user()
            ->notifications()
            ->where('read', false)
            ->update([
                'read' => true,
            ]);

        return back();
    }
}