<?php

namespace App\Services\AI\Clients;

use OpenAI;

class OpenAIClient
{
    public function make()
    {
        return OpenAI::client(
            config('ai.openai.api_key')
        );
    }
}