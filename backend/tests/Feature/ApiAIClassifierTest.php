<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiAIClassifierTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_classify_ticket()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson(
            '/api/v1/ai/classify-ticket',
            [
                'title' => 'Impressora não imprime',
                'description' => 'Equipamento parado',
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'category',
                'priority',
                'confidence',
            ]);
    }
}