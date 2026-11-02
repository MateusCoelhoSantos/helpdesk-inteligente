<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;

class AIController extends Controller
{
    public function classifyTicket(
    Request $request,
    AIProvider $ai
    ) {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        return response()->json(
            $ai->classify(
                $validated['title'],
                $validated['description']
            )
        );
    }

    public function summarizeTicket(
        Ticket $ticket,
        AIProvider $ai
    ) {

        $ticket->load('comments');

        return response()->json([
            'summary' => $ai->summarize(
                $ticket
            ),
        ]);
    }

    public function suggestReply(
        Ticket $ticket,
        AIProvider $ai
    )
    {
        $ticket->load('comments');

        return response()->json([
            'reply' => $ai->suggestReply(
                $ticket
            ),
        ]);
    }

}