<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketAttachment;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;


class AttachmentController extends Controller
{
    public function index(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return AttachmentResource::collection(
            $ticket->attachments()
                ->with('user:id,name')
                ->latest()
                ->paginate(20)
        );
    }

    public function store(
        Request $request,
        Ticket $ticket
    )
    {
        $this->authorize('view', $ticket);

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:5120',
            ],
        ]);

        $path = $request
            ->file('file')
            ->store(
                'attachments',
                'public'
            );

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'original_name' => $request
                ->file('file')
                ->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return (new AttachmentResource($attachment))
            ->response()
            ->setStatusCode(201);
    }
}
