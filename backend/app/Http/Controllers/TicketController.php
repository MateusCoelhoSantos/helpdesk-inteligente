<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->isAdmin()) {

            $query = Ticket::query();

        } else {

            $query = Ticket::where(
                'user_id',
                auth()->id()
            );

        }

        if ($request->filled('q')) {
            $query->where(
                'title',
                'like',
                '%' . $request->q . '%'
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $tickets = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'priority' => ['required', 'in:low,medium,high,critical'],
        ]);

        $validated['user_id'] = auth()->id();

        Ticket::create($validated);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado criado com sucesso!');
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $users = \App\Models\User::orderBy('name')->get();

        return view(
            'tickets.edit',
            compact('ticket', 'users')
        );
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'priority' => ['required', 'in:low,medium,high,critical'],
            'status' => ['required', 'in:open,in_progress,waiting,resolved'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $ticket->update($validated);

        if (!auth()->user()->isAdmin()) {
            unset($validated['assigned_to']);
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Chamado atualizado com sucesso!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado excluído com sucesso!');
    }
}
