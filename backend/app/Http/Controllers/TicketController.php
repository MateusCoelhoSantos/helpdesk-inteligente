<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketHistory;
use App\Models\User;

class TicketController extends Controller
{
    private function translateStatus(string $status): string
    {
        return match ($status) {
            'open' => 'Aberto',
            'in_progress' => 'Em andamento',
            'waiting' => 'Aguardando',
            'resolved' => 'Resolvido',
            default => $status,
        };
    }

    private function translatePriority(string $priority): string
    {
        return match ($priority) {
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta',
            'critical' => 'Crítica',
            default => $priority,
        };
    }

    private function translateCategory(?string $category): string
    {
        return match ($category) {
            'hardware' => 'Hardware',
            'software' => 'Software',
            'network' => 'Rede',
            'access' => 'Acesso e Permissões',
            'other' => 'Outro',
            null => 'Não definida',
            default => $category,
        };
    }

    public function index(Request $request)
    {
        if (auth()->user()->isAdmin()) {

            $query = Ticket::query();

        } else {

            $query = Ticket::where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('assigned_to', auth()->id());
            });

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
        $ticket->load([
            'histories.user',
            'comments.user',
            'assignedUser',
            'user',
        ]);

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
        $responsavelAntigo = $ticket->assigned_to;
        $categoryAntigo = $ticket->category;

        $ticket->update($validated);

        $usuarioAtual = auth()->user()->name;

        if ($responsavelAntigo != $ticket->assigned_to) {

            if (is_null($responsavelAntigo) && $ticket->assignedUser) {

                $this->addHistory(
                    $ticket,
                    'assigned',
                    "{$usuarioAtual} atribuiu o chamado para {$ticket->assignedUser->name}"
                );

            } elseif (!is_null($responsavelAntigo) && is_null($ticket->assigned_to)) {

                $this->addHistory(
                    $ticket,
                    'unassigned',
                    "{$usuarioAtual} removeu o responsável do chamado"
                );

            } else {

                $responsavelAnterior = User::find($responsavelAntigo);

                $this->addHistory(
                    $ticket,
                    'reassigned',
                    "{$usuarioAtual} alterou o responsável de {$responsavelAnterior->name} para {$ticket->assignedUser->name}"
                );
            }
        }

        if ($statusAntigo !== $ticket->status) {
            $this->addHistory(
                $ticket,
                'status_changed',
                "{$usuarioAtual} alterou o status de ". $this->translateStatus($statusAntigo). " para ". $this->translateStatus($ticket->status)
            );
        }

        if ($prioridadeAntiga !== $ticket->priority) {
            $this->addHistory(
                $ticket,
                'priority_changed',
                "{$usuarioAtual} alterou a prioridade de " . $this->translatePriority($prioridadeAntiga) . " para " . $this->translatePriority($ticket->priority)
            );
        }

        if ($categoryAntigo !== $ticket->category) {
            $this->addHistory(
                $ticket,
                'category_changed',
                "{$usuarioAtual} alterou a categoria de " . $this->translateCategory($categoryAntigo) . " para " . $this->translateCategory($ticket->category)
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
