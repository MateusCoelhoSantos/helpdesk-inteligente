<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '12345678',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user',
            ]);
    }

    public function test_user_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'senha_errada',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Credenciais inválidas.'
            ]);
    }
}