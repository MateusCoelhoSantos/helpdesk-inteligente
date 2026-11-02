<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AI\Providers\OpenAIProvider;

class OpenAIProviderTest extends TestCase
{
    public function test_openai_provider_returns_classification()
    {
        $provider = app(
            OpenAIProvider::class
        );

        $result = $provider->classify(
            'Impressora não imprime',
            'Equipamento parado'
        );

        $this->assertIsArray($result);

        $this->assertArrayHasKey(
            'category',
            $result
        );

        $this->assertArrayHasKey(
            'priority',
            $result
        );

        $this->assertArrayHasKey(
            'confidence',
            $result
        );
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