<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    public function index()
    {
        return TicketResource::collection(
            Ticket::latest()->paginate(15)
        );
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

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