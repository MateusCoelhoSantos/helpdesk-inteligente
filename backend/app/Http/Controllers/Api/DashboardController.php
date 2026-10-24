<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([

            'total_tickets' => Ticket::count(),

            'open_tickets' => Ticket::where(
                'status',
                'open'
            )->count(),

            'in_progress_tickets' => Ticket::where(
                'status',
                'in_progress'
            )->count(),

            'waiting_tickets' => Ticket::where(
                'status',
                'waiting'
            )->count(),

            'resolved_tickets' => Ticket::where(
                'status',
                'resolved'
            )->count(),

            'critical_tickets' => Ticket::where(
                'priority',
                'critical'
            )->count(),

        ]);
    }
}