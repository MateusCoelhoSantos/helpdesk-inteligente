<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketComment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function index(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return CommentResource::collection(
            $ticket->comments()
                ->with('user:id,name')
                ->latest()
                ->paginate(20)
        );
    }

    public function store(
        Request $request,
        Ticket $ticket
    ) {
        $this->authorize('view', $ticket);

        $validated = $request->validate([
            'message' => ['required', 'string']
        ]);

        $comment = TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
        ]);

        return (new CommentResource(
            $comment->load('user:id,name')
        ))->response()->setStatusCode(201);
    }
}