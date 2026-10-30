<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    /**
     * Lista tickets com filtros e paginação.
     * Requer autenticação via Sanctum.
     */
    /**
     * Lista tickets.
     *
     * Filtros disponíveis:
     * - status
     * - priority
     * - category
     * - q
     *
     * Ordenação:
     * - sort
     * - direction
     */
    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where(
                    'title',
                    'like',
                    '%' . $request->q . '%'
                )
                ->orWhere(
                    'description',
                    'like',
                    '%' . $request->q . '%'
                );
            });
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

        $allowedSorts = [
            'created_at',
            'updated_at',
            'priority',
            'status',
            'title',
        ];

        $sort = $request->get('sort', 'created_at');

        if (! in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $direction = strtolower(
            $request->get('direction', 'desc')
        );

        if (! in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        return TicketResource::collection(
            $query
                ->orderBy($sort, $direction)
                ->paginate(15)
                ->withQueryString()
        );
    }

    /**
     * Retorna um ticket específico.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Cria um novo ticket.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required'],
            'priority' => ['required'],
        ]);

        $validated['user_id'] = $request->user()->id;

        $ticket = Ticket::create([
            ...$validated,
            'status' => 'open',
        ]);

        return response()->json([
            'message' => 'Chamado criado com sucesso.',
            'ticket' => new TicketResource($ticket)
        ], 201);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize(
            'update',
            $ticket
        );
        
        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'category' => ['sometimes'],
            'priority' => ['sometimes'],
            'status' => ['sometimes'],
        ]);

        if (
            isset($validated['status']) &&
            $validated['status'] === 'resolved' &&
            $ticket->status !== 'resolved'
        ) {
            $validated['resolved_at'] = now();
        }

        $ticket->update($validated);

        return response()->json([
            'message' => 'Chamado atualizado com sucesso.',
            'ticket' => new TicketResource($ticket->fresh())
        ]);
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize(
            'delete', 
            $ticket
        );

        $ticket->delete();

        return response()->json([
            'message' => 'Chamado removido com sucesso.'
        ]);
    }
}