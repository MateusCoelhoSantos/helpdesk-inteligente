<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\AIGeneration;
use App\Models\KnowledgeArticle;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\AI\Contracts\AIProvider;

class GenerateKnowledgeArticleJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $ticketId
    ) {
    }

    public function handle(
        AIProvider $ai
    ): void {

        $ticket = Ticket::with(
            'comments'
        )->findOrFail(
            $this->ticketId
        );

        $generation = AIGeneration::create([
            'ticket_id' => $ticket->id,
            'type' => 'knowledge_article',
            'status' => 'processing',
        ]);

        try {

            $article = $ai
                ->generateKnowledgeArticle(
                    $ticket
                );

            $knowledgeArticle =
                KnowledgeArticle::create([
                    'ticket_id' => $ticket->id,
                    'title' => $article['title'],
                    'problem' => $article['problem'],
                    'cause' => $article['cause'],
                    'solution' => $article['solution'],
                    'prevention' => $article['prevention'],
                ]);

            $generation->update([
                'status' => 'completed',
                'result' => $knowledgeArticle
                    ->toArray(),
            ]);

        } catch (\Throwable $exception) {

            $generation->update([
                'status' => 'failed',
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}