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
            : Ticket::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('assigned_to', $user->id);
            });

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

        $criticalTickets = (clone $query)
            ->where('priority', 'critical')
            ->count();

        $assignedToMe = (clone $query)
            ->where('assigned_to', $user->id)
            ->count();

        $unassignedTickets = (clone $query)
            ->whereNull('assigned_to')
            ->count();

        $recentTickets = (clone $query)
            ->latest()
            ->take(5)
            ->get();

        $statusChart = [
            'open' => (clone $query)
                ->where('status', 'open')
                ->count(),

            'in_progress' => (clone $query)
                ->where('status', 'in_progress')
                ->count(),

            'waiting' => (clone $query)
                ->where('status', 'waiting')
                ->count(),

            'resolved' => (clone $query)
                ->where('status', 'resolved')
                ->count(),
        ];

        $categoriesChart = [
            'hardware' => (clone $query)->where('category', 'hardware')->count(),
            'software' => (clone $query)->where('category', 'software')->count(),
            'network' => (clone $query)->where('category', 'network')->count(),
            'access' => (clone $query)->where('category', 'access')->count(),
            'other' => (clone $query)->where('category', 'other')->count(),
        ];

        $attentionTickets = (clone $query)
            ->where('priority', 'critical')
            ->where('status', '!=', 'resolved')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'waitingTickets',
            'resolvedTickets',
            'criticalTickets',
            'assignedToMe',
            'unassignedTickets',
            'statusChart',
            'categoriesChart',
            'attentionTickets',
            'recentTickets'
        ));
    }
}