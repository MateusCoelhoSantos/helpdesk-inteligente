<?php

namespace App\Services\AI\Providers;

use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;
use App\Services\AI\Clients\OpenAIClient;

class OpenAIProvider implements AIProvider
{
    public function classify(
        string $title,
        string $description
    ): array {

        try {

            // chamada real virá aqui

            return [
                'category' => 'ai-category',
                'priority' => 'medium',
                'confidence' => 0.95,
            ];

        } catch (\Throwable $e) {

            return app(
                RuleBasedAIProvider::class
            )->classify(
                $title,
                $description
            );
        }
    }

    public function summarize(
        Ticket $ticket
    ): string {
        return sprintf(
            '[OPENAI] Resumo do ticket: %s',
            $ticket->title
        );
    }

    public function suggestReply(
        string $message
    ): string {
        return '[OPENAI] Resposta sugerida automaticamente.';
    }

    public function __construct(
        private OpenAIClient $client
    ) {
    }

    public function test_openai_provider_can_fallback()
    {
        $provider = app(
            OpenAIProvider::class
        );

        $result = $provider->classify(
            'Impressora não imprime',
            'Equipamento parado'
        );

        $this->assertIsArray(
            $result
        );

        $this->assertArrayHasKey(
            'category',
            $result
        );
    }
}