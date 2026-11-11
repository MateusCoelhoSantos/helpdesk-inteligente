<?php

namespace App\Services\AI\Providers;

use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;
use App\Services\AI\Clients\OpenAIClient;
use App\Services\AI\Prompts\TicketClassificationPrompt;
use App\Services\AI\Concerns\ExtractsJson;
use App\Services\AI\Concerns\ValidatesClassification;

class OpenAIProvider implements AIProvider
{
    use ExtractsJson;
    use ValidatesClassification;

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

    public function summarize(
        Ticket $ticket
    ): string {
        return sprintf(
            '[OPENAI] Resumo do ticket: %s',
            $ticket->title
        );
    }

    public function suggestReply(
        Ticket $ticket
    ): string
    {
        return '[OPENAI] resposta';
    }

    public function __construct(
        private OpenAIClient $client
    ) {
    }

    public function generateKnowledgeArticle(
        Ticket $ticket
    ): array {

        return [
            'title' => '',
            'problem' => '',
            'cause' => '',
            'solution' => '',
            'prevention' => '',
        ];
    }

    public function generateClosureReport(
        Ticket $ticket
    ): array
    {
        return [
            'incident_summary' => '',
            'root_cause' => '',
            'solution' => '',
            'lessons_learned' => '',
        ];
    }
}