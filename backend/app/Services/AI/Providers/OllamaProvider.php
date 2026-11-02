<?php

namespace App\Services\AI\Providers;

use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;
use App\Services\AI\Clients\OllamaClient;
use App\Services\AI\Prompts\TicketClassificationPrompt;
use App\Services\AI\Concerns\ExtractsJson;
use App\Services\AI\Concerns\ValidatesClassification;
use App\Services\AI\Prompts\TicketSummaryPrompt;
use App\Services\AI\Prompts\TicketReplyPrompt;
use App\Services\AI\Prompts\TicketClosurePrompt;
use App\Services\AI\Concerns\ValidatesClosureReport;

class OllamaProvider implements AIProvider
{
    use ExtractsJson;
    use ValidatesClassification;
    use ValidatesClosureReport;


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

        $response = $this->client->chat(
            TicketSummaryPrompt::make(
                $ticket
            )
        );

        return trim(
            $response['response']
        );
    }

    public function suggestReply(
        Ticket $ticket
    ): string {

        $response = $this->client->chat(
            TicketReplyPrompt::make(
                $ticket
            )
        );

        return trim(
            $response['response']
        );
    }

    public function generateClosureReport(
        Ticket $ticket
    ): array {

        $response = $this->client->chat(
            TicketClosurePrompt::make(
                $ticket
            )
        );

        $result = $this->extractJson(
            $response['response']
        );

        return $this->validateClosureReport(
            $result
        );
    }

}