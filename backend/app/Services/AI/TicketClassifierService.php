<?php

namespace App\Services\AI;

class TicketClassifierService
{
    public function classify(
        string $title,
        string $description
    ): array {
        $text = strtolower(
            $title.' '.$description
        );

        return [
            'category' => $this->detectCategory($text),
            'priority' => $this->detectPriority($text),
            'confidence' => 0.85,
        ];
    }

    protected function detectCategory(string $text): string
    {
        if (
            str_contains($text, 'impressora') ||
            str_contains($text, 'scanner')
        ) {
            return 'hardware';
        }

        if (
            str_contains($text, 'internet') ||
            str_contains($text, 'rede')
        ) {
            return 'network';
        }

        if (
            str_contains($text, 'email') ||
            str_contains($text, 'outlook')
        ) {
            return 'software';
        }

        return 'general';
    }

    protected function detectPriority(string $text): string
    {
        if (
            str_contains($text, 'urgente') ||
            str_contains($text, 'parado')
        ) {
            return 'high';
        }

        return 'medium';
    }
}