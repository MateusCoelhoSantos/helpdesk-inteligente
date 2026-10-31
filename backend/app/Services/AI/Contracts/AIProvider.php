<?php

namespace App\Services\AI\Contracts;

use App\Models\Ticket;

interface AIProvider
{
    public function classify(
        string $title,
        string $description
    ): array;

    public function summarize(
        Ticket $ticket
    ): string;

    public function suggestReply(
        string $message
    ): string;
}