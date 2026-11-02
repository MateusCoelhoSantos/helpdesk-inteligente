<?php

namespace App\Services\AI\Clients;

use Illuminate\Support\Facades\Http;

class OllamaClient
{
    public function chat(
        string $prompt
    ): array {

        return Http::post(
            config('ai.ollama.base_url') . '/api/generate',
            [
                'model' => config(
                    'ai.ollama.model'
                ),

                'prompt' => $prompt,

                'stream' => false,
            ]
        )->json();
    }
}