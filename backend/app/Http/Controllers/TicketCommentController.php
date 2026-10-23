<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use App\Models\TicketHistory;
use App\Models\TicketAttachment;

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
