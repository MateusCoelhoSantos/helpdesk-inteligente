<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketHistory;

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

        $ticket = Ticket::create($validated);

        $this->addHistory(
            $ticket,
            'created',
            'Chamado criado'
        );

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

        if (!auth()->user()->isAdmin()) {
            unset($validated['assigned_to']);
        }

        $statusAntigo = $ticket->status;
        $prioridadeAntiga = $ticket->priority;
        $ResponsavelAntigo = $ticket->assigned_to;
        $categoryAntigo = $ticket->category;

        $ticket->update($validated);

        if ($statusAntigo !== $ticket->status) {
            $this->addHistory(
                $ticket,
                'status_changed',
                "Status alterado de {$statusAntigo} para {$ticket->status}"
            );
        }

        if ($prioridadeAntiga !== $ticket->priority) {
            $this->addHistory(
                $ticket,
                'priority_changed',
                "Prioridade alterada de {$prioridadeAntiga} para {$ticket->priority}"
            );
        }

        if ($ResponsavelAntigo !== $ticket->assigned_to) {
            $this->addHistory(
                $ticket,
                'assigned_to_changed',
                "Responsável alterado de {$ResponsavelAntigo} para {$ticket->assigned_to}"
            );
        }

        if ($categoryAntigo !== $ticket->category) {
            $this->addHistory(
                $ticket,
                'category_changed',
                "Categoria alterada de {$categoryAntigo} para {$ticket->category}"
            );
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

    private function addHistory(
        Ticket $ticket,
        string $action,
        string $description
    ): void {
        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
        ]);
    }
}
