<?php

namespace App\Services\AI\Providers;

use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;
use App\Services\AI\Clients\OpenAIClient;
use App\Services\AI\Prompts\TicketClassificationPrompt;
use App\Services\AI\Concerns\ExtractsJson;

class OpenAIProvider implements AIProvider
{
    use ExtractsJson;

    public function classify(
        string $title,
        string $description
    ): array {

        try {

            $response = $this->client
                ->make()
                ->chat()
                ->create([
                    'model' => config(
                        'ai.openai.model'
                    ),

                    'messages' => [
                        [
                            'role' => 'system',
                            'content' =>
                                'Você classifica tickets de helpdesk. Retorne apenas JSON.'
                        ],
                        [
                            'role' => 'user',
                            'content' => TicketClassificationPrompt::make(
                                $title,
                                $description
                            ),
                        ],
                    ],
                ]);

            $content = $response
                ->choices[0]
                ->message
                ->content;

            $result = $this->extractJson(
                $content
            );

            return $this->validateClassification(
                $result
            );

        } catch (\Throwable $e) {
        
            return [
                'category' => 'other',
                'priority' => 'medium',
                'confidence' => 0.0,
                'provider' => 'openai-fallback',
            ];  

        }

    }

    private function validateClassification(
        array $data
    ): array
    {
        $categories = [
            'hardware',
            'software',
            'network',
            'access',
            'other',
        ];

        $priorities = [
            'low',
            'medium',
            'high',
            'critical'
        ];

        if (! in_array(
            $data['category'] ?? '',
            $categories
        )) {
            $data['category'] = 'other';
        }

        if (! in_array(
            $data['priority'] ?? '',
            $priorities
        )) {
            $data['priority'] = 'medium';
        }

        return $data;
    }

    private function extractJson(
        string $content
    ): array
    {
        $content = str_replace(
            ['```json', '```'],
            '',
            $content
        );

        return json_decode(
            trim($content),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
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
}