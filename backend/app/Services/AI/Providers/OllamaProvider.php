<?php

namespace App\Services\AI\Providers;

use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;
use App\Services\AI\Clients\OllamaClient;
use App\Services\AI\Prompts\TicketClassificationPrompt;
use App\Services\AI\Concerns\ExtractsJson;
use App\Services\AI\Concerns\ValidatesClassification;

class OllamaProvider implements AIProvider
{
    use ExtractsJson;
    use ValidatesClassification;

    public function __construct(
        private OllamaClient $client
    ) {
    }

    public function classify(
        string $title,
        string $description
    ): array {

        try {

            $response = $this->client->chat(
                TicketClassificationPrompt::make(
                    $title,
                    $description
                )
            );

            $result = $this->extractJson(
                $response['response']
            );

            $result = $this->validateClassification(
                $result
            );

            $result['provider'] = 'ollama';

            return $result;

        } catch (\Throwable $e) {

            return [
                'category' => 'other',
                'priority' => 'medium',
                'confidence' => 0.0,
                'provider' => 'ollama-fallback',
            ];
        }
    }

    public function summarize(
        Ticket $ticket
    ): string {

        return '[OLLAMA] resumo';
    }

    public function suggestReply(
        string $message
    ): string {

        return '[OLLAMA] resposta';
    }

}