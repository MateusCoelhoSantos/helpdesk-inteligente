<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\User;

class HistoryService
{
    public function record(
        Ticket $ticket,
        ?User $user,
        string $action,
        string $description
    ): void {

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user?->id,
            'action' => $action,
            'description' => $description,
        ]);
    }
}