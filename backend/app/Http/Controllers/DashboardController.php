<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = $user->isAdmin()
            ? Ticket::query()
            : Ticket::where('user_id', $user->id);

        $totalTickets = (clone $query)->count();

        $openTickets = (clone $query)
            ->where('status', 'open')
            ->count();

        $inProgressTickets = (clone $query)
            ->where('status', 'in_progress')
            ->count();

        $waitingTickets = (clone $query)
            ->where('status', 'waiting')
            ->count();

        $resolvedTickets = (clone $query)
            ->where('status', 'resolved')
            ->count();

        $recentTickets = (clone $query)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'waitingTickets',
            'resolvedTickets',
            'recentTickets'
        ));
    }
}