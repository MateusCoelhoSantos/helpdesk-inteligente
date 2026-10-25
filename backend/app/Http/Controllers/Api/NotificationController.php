<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()
            ->user()
            ->notifications()
            ->paginate(15);

        return NotificationResource::collection(
            $notifications
        );
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {

            return response()->json([
                'message' => 'Acesso negado.'
            ], 403);

        }

        $notification->update([
            'read' => true
        ]);

        return response()->json([
            'message' => 'Notificação marcada como lida.'
        ]);
    }

    public function markAllAsRead()
    {
        auth()
            ->user()
            ->notifications()
            ->where('read', false)
            ->update([
                'read' => true
            ]);

        return response()->json([
            'message' => 'Todas as notificações foram marcadas como lidas.'
        ]);
    }
}