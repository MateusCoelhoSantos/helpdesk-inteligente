<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;
use App\Models\TicketComment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiCommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_list_comments()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        TicketComment::factory()
            ->count(3)
            ->create([
                'ticket_id' => $ticket->id,
            ]);

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/comments"
        );

        $response->assertStatus(200);

        $response->assertJsonCount(3);
    }

    public function test_authenticated_user_can_create_comment()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->postJson(
            "/api/v1/tickets/{$ticket->id}/comments",
            [
                'message' => 'Comentário de teste',
            ]
        );

        $response->assertStatus(201);

        $this->assertDatabaseHas(
            'ticket_comments',
            [
                'ticket_id' => $ticket->id,
                'message' => 'Comentário de teste',
            ]
        );
    }


    public function test_guest_cannot_list_comments()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/comments"
        );

        $response->assertStatus(401);
    }

    public function test_guest_cannot_create_comment()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->postJson(
            "/api/v1/tickets/{$ticket->id}/comments",
            [
                'message' => 'Comentário'
            ]
        );

        $response->assertStatus(401);
    }

    public function test_user_cannot_view_comments_from_other_users_ticket()
    {
        $owner = User::factory()->create();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $owner->id,
        ]);

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/comments"
        );

        $response->assertStatus(403);
    }
}
