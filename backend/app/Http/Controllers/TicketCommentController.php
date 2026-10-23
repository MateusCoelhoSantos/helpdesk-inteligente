<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use App\Models\TicketHistory;
use App\Models\TicketAttachment;
use App\Models\Notification;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'message' => ['required', 'string'],

            'attachments' => ['nullable', 'array'],
            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:5120',
            ],
        ]);


        $comment = TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'commented',
            'description' => auth()->user()->name . ' adicionou um comentário',
        ]);

        if ($ticket->user_id !== auth()->id()) {

            Notification::create([
                'user_id' => $ticket->user_id,
                'title' => 'Novo comentário',
                'message' => auth()->user()->name . ' comentou em seu chamado.',
                'type' => 'info',
                'url' => route('tickets.show', $ticket),
            ]);
        }

        if (
            $ticket->assigned_to &&
            $ticket->assigned_to !== auth()->id()
        ) {

            Notification::create([
                'user_id' => $ticket->assigned_to,
                'title' => 'Novo comentário',
                'message' => auth()->user()->name . ' comentou em um chamado atribuído a você.',
                'type' => 'info',
                'url' => route('tickets.show', $ticket),
            ]);
        }

        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $file) {

                $path = $file->store(
                    'attachments',
                    'public'
                );

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'comment_id' => $comment->id,
                    'user_id' => auth()->id(),
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Comentário adicionado com sucesso!');
    }
}
