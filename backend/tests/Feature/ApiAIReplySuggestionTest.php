<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ticket;

class ApiAIReplySuggestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_reply_suggestion(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $ticket = Ticket::factory()->create([
            'title' => 'Problema no Outlook',
            'description' => 'Não consigo acessar o Outlook',
        ]);

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/suggest-reply"
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'reply',
            ]);
    }
}