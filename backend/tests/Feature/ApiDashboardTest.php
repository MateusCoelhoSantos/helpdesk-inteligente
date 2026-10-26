<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_dashboard_metrics()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson(
            '/api/v1/dashboard'
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'total_tickets',
                'open_tickets',
                'in_progress_tickets',
                'waiting_tickets',
                'resolved_tickets',
                'critical_tickets',
            ]);
    }
}