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

        $response = $this->getJson('/api/v1/tickets');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_guest_cannot_list_tickets()
    {
        $response = $this->getJson('/api/v1/tickets');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_ticket()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/tickets', [

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

    public function test_admin_can_resolve_ticket()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'status' => 'open',
            'resolved_at' => null,
        ]);

        $response = $this->putJson(
            "/api/v1/tickets/{$ticket->id}",
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

    public function test_admin_can_delete_ticket()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create();

        $response = $this->deleteJson(
            "/api/v1/tickets/{$ticket->id}"
        );

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id
        ]);
    }

    public function test_non_admin_cannot_delete_ticket()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create();

        $response = $this->deleteJson(
            "/api/v1/tickets/{$ticket->id}"
        );

        $response->assertStatus(403);
    }

    public function test_ticket_creation_requires_required_fields()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson(
            '/api/v1/tickets',
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

    public function test_can_filter_tickets_by_status()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Ticket::factory()->create([
            'status' => 'open',
        ]);

        Ticket::factory()->create([
            'status' => 'resolved',
        ]);

        $response = $this->getJson(
            '/api/v1/tickets?status=open'
        );

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_filter_tickets_by_priority()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Ticket::factory()->create([
            'priority' => 'high',
        ]);

        Ticket::factory()->create([
            'priority' => 'low',
        ]);

        $response = $this->getJson(
            '/api/v1/tickets?priority=high'
        );

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_filter_tickets_by_category()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Ticket::factory()->create([
            'category' => 'hardware',
        ]);

        Ticket::factory()->create([
            'category' => 'network',
        ]);

        $response = $this->getJson(
            '/api/v1/tickets?category=hardware'
        );

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_search_tickets()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Ticket::factory()->create([
            'title' => 'Problema na impressora',
        ]);

        Ticket::factory()->create([
            'title' => 'Falha no servidor',
        ]);

        $response = $this->getJson(
            '/api/v1/tickets?q=impressora'
        );

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_sort_tickets_ascending()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Ticket::factory()->create([
            'title' => 'Zeta'
        ]);

        Ticket::factory()->create([
            'title' => 'Alpha'
        ]);

        $response = $this->getJson(
            '/api/v1/tickets?sort=title&direction=asc'
        );

        $response
            ->assertStatus(200);

        $this->assertEquals(
            'Alpha',
            $response->json('data.0.title')
        );
    }

    public function test_can_sort_tickets_descending()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Ticket::factory()->create([
            'title' => 'Alpha'
        ]);

        Ticket::factory()->create([
            'title' => 'Zeta'
        ]);

        $response = $this->getJson(
            '/api/v1/tickets?sort=title&direction=desc'
        );

        $response
            ->assertStatus(200);

        $this->assertEquals(
            'Zeta',
            $response->json('data.0.title')
        );
    }

    public function test_invalid_sort_field_falls_back_to_default()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson(
            '/api/v1/tickets?sort=hacker_field'
        );

        $response->assertStatus(200);
    }
}