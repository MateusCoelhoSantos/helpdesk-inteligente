<?php

namespace App\Services\AI;

use App\Models\Ticket;

class TicketSummaryService
{
    public function summarize(Ticket $ticket): string
    {
        $commentsCount = $ticket->comments()->count();

        $historyCount = $ticket->histories()->count();

        return sprintf(
            'Chamado "%s" (%s). Possui %s comentário(s), %s registro(s) de histórico e status atual "%s".',
            $ticket->title,
            $ticket->category,
            $commentsCount,
            $historyCount,
            $ticket->status
        );
    }
}
