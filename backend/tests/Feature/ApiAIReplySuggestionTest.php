<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiAIReplySuggestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_reply_suggestion()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson(
            '/api/v1/ai/suggest-reply',
            [
                'message' => 'Não consigo acessar o Outlook'
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'suggestion',
            ]);
    }
}