<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Notification;

class ApiNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_notifications()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        Notification::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson(
            '/api/v1/notifications'
        );

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_guest_cannot_list_notifications()
    {
        $response = $this->getJson(
            '/api/v1/notifications'
        );

        $response->assertStatus(401);
    }

    public function test_user_can_mark_notification_as_read()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $notification = Notification::factory()
            ->create([
                'user_id' => $user->id,
                'read' => false,
            ]);

        $response = $this->patchJson(
            "/api/v1/notifications/{$notification->id}/read"
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas(
            'notifications',
            [
                'id' => $notification->id,
                'read' => true,
            ]
        );
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        Notification::factory()
            ->count(5)
            ->create([
                'user_id' => $user->id,
                'read' => false,
            ]);

        $response = $this->patchJson(
            '/api/v1/notifications/read-all'
        );

        $response->assertStatus(200);

        $this->assertDatabaseMissing(
            'notifications',
            [
                'user_id' => $user->id,
                'read' => false,
            ]
        );
    }

}