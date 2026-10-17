<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);

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
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'priority' => ['required', 'in:low,medium,high,critical'],
            'status' => ['required', 'in:open,in_progress,waiting,resolved'],
        ]);

        $ticket->update($validated);

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
