<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AI\TicketClassifierService;
use App\Models\Ticket;
use App\Services\AI\TicketSummaryService;
use App\Services\AI\ReplySuggestionService;

class AIController extends Controller
{
    public function classifyTicket(
        Request $request,
        TicketClassifierService $classifier
    ) {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        return response()->json(
            $classifier->classify(
                $validated['title'],
                $validated['description']
            )
        );
    }

    public function summarizeTicket(
    Ticket $ticket,
    TicketSummaryService $summaryService
    ) {
        $this->authorize('view', $ticket);

        return response()->json([
            'summary' => $summaryService->summarize($ticket),
        ]);
    }

    public function suggestReply(
    Request $request,
    ReplySuggestionService $service
    ) {
        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        return response()->json([
            'suggestion' => $service->suggest(
                $validated['message']
            ),
        ]);
    }
}