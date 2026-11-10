<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;
use App\Models\AIGeneration;

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

        $generation = AIGeneration::create([
            'ticket_id' => $ticket->id,
            'type' => 'summary',
            'status' => 'processing',
        ]);

        try {

            $summary = $ai->summarize(
                $ticket
            );

            $generation->update([
                'status' => 'completed',
                'result' => [
                    'summary' => $summary,
                ],
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
