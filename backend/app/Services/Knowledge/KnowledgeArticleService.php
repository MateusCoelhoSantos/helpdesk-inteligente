<?php

namespace App\Services\Knowledge;

use App\Models\Ticket;
use App\Models\KnowledgeArticle;
use App\Services\AI\Contracts\AIProvider;

class KnowledgeArticleService
{
    public function generateFromTicket(
        Ticket $ticket,
        AIProvider $ai
    ): KnowledgeArticle {

        $ticket->load('comments');

        $article = $ai
            ->generateKnowledgeArticle(
                $ticket
            );

        return KnowledgeArticle::create([
            'ticket_id' => $ticket->id,

            'title' => $article['title'],

            'problem' => $article['problem'],

            'cause' => $article['cause'],

            'solution' => $article['solution'],

            'prevention' => $article['prevention'],
        ]);
    }
}