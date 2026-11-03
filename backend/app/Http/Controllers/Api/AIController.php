<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;
use App\Services\Knowledge\KnowledgeArticleService;
use App\Models\KnowledgeArticle;

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

    public function closureReport(
        Ticket $ticket,
        AIProvider $ai
    )
    {
        $ticket->load('comments');

        return response()->json([
            'report' => $ai->generateClosureReport(
                $ticket
            ),
        ]);
    }

    public function knowledgeArticle(
        Ticket $ticket,
        AIProvider $ai
    )
    {
        $ticket->load('comments');

        return response()->json([
            'article' => $ai->generateKnowledgeArticle(
                $ticket
            ),
        ]);
    }

    public function generateKnowledgeArticle(
        Ticket $ticket,
        AIProvider $ai,
        KnowledgeArticleService $service
    )
    {
        return response()->json(
            $service->generateFromTicket(
                $ticket,
                $ai
            )
        );
    }

    public function listKnowledgeArticles()
    {
        return KnowledgeArticle::latest()
            ->paginate();
    }

    public function searchKnowledgeArticles(
        Request $request
    )
    {
        return KnowledgeArticle::query()

            ->when(
                $request->q,
                fn ($query) => $query->where(
                    'title',
                    'like',
                    '%' . $request->q . '%'
                )
            )

            ->paginate();
    }

}