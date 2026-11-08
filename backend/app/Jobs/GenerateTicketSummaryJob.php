<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;

class GenerateTicketSummaryJob
    implements ShouldQueue
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

        $summary = $ai->summarize(
            $ticket
        );

        $ticket->update([
            'ai_summary' => $summary,
        ]);
    }
}
