<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalTickets = Ticket::where(
            'user_id',
            $userId
        )->count();

        $openTickets = Ticket::where(
            'user_id',
            $userId
        )->where(
            'status',
            'open'
        )->count();

        $resolvedTickets = Ticket::where(
            'user_id',
            $userId
        )->where(
            'status',
            'resolved'
        )->count();

        $recentTickets = Ticket::where(
            'user_id',
            $userId
        )
        ->latest()
        ->take(5)
        ->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'resolvedTickets',
            'recentTickets'
        ));
    }
}