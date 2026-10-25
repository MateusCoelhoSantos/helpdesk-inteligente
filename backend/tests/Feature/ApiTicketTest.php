<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_tickets()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        Ticket::factory()->count(3)->create();

        $response = $this->getJson('/api/tickets');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_guest_cannot_list_tickets()
    {
        $response = $this->getJson('/api/tickets');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_ticket()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/tickets', [

            'title' => 'Teste API',

            'description' => 'Descrição teste',

            'category' => 'software',

            'priority' => 'high',

        ]);

        $response
            ->assertStatus(201);

        $this->assertDatabaseHas('tickets', [

            'title' => 'Teste API'

        ]);
    }

    public function test_authenticated_user_can_resolve_ticket()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'status' => 'open',
            'resolved_at' => null,
        ]);

        $response = $this->putJson(
            "/api/tickets/{$ticket->id}",
            [
                'status' => 'resolved'
            ]
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'resolved',
        ]);

        $ticket->refresh();

        $this->assertNotNull(
            $ticket->resolved_at
        );
    }

    public function test_authenticated_user_can_delete_ticket()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create();

        $response = $this->deleteJson(
            "/api/tickets/{$ticket->id}"
        );

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id
        ]);
    }

    public function test_ticket_creation_requires_required_fields()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson(
            '/api/tickets',
            []
        );

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'title',
            'description',
            'category',
            'priority',
        ]);
    }
}