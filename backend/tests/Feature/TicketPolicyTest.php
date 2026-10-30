<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;

class TicketPolicyTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_admin_can_view_any_ticket()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $ticket = Ticket::factory()->create();

        $this->assertTrue(
            $admin->can('view', $ticket)
        );
    }

    public function test_owner_can_view_own_ticket()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue(
            $user->can('view', $ticket)
        );
    }

    public function test_user_cannot_view_another_users_ticket()
    {
        $owner = User::factory()->create();

        $otherUser = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $owner->id,
        ]);

        $this->assertFalse(
            $otherUser->can('view', $ticket)
        );
    }

    public function test_admin_can_update_ticket()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $ticket = Ticket::factory()->create();

        $this->assertTrue(
            $admin->can('update', $ticket)
        );
    }

    public function test_owner_can_update_own_ticket()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue(
            $user->can('update', $ticket)
        );
    }

    public function test_non_admin_cannot_delete_ticket()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->create();

        $this->assertFalse(
            $user->can('delete', $ticket)
        );
    }

    public function test_admin_can_delete_ticket()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $ticket = Ticket::factory()->create();

        $this->assertTrue(
            $admin->can('delete', $ticket)
        );
    }
}
