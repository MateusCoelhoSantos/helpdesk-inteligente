<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiAITicketSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_ticket_summary()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson(
            "/api/v1/ai/tickets/{$ticket->id}/summary"
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'summary',
            ]);
    }
}