<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;
use App\Models\TicketHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiHistoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_list_history()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        TicketHistory::factory()
            ->count(3)
            ->create([
                'ticket_id' => $ticket->id,
            ]);

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/history"
        );

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);
    }

    public function test_guest_cannot_view_history()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/history"
        );

        $response->assertStatus(401);
    }

    public function test_user_cannot_view_other_users_history()
    {
        $owner = User::factory()->create();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $owner->id,
        ]);

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/history"
        );

        $response->assertStatus(403);
    }
}
