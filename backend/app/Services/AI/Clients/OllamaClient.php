<?php

namespace App\Services\AI\Clients;

use Illuminate\Support\Facades\Http;

class OllamaClient
{
    public function chat(
        string $prompt
    ): array {

        return Http::timeout(120)
            ->connectTimeout(10)
            ->retry(2, 1000)
            ->post(
                config('ai.ollama.base_url').'/api/generate',
                [
                    'model' => config('ai.ollama.model'),
                    'prompt' => $prompt,
                    'stream' => false,
                ]
            )
            ->throw()
            ->json();
    }
}