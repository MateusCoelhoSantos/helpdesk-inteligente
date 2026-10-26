<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [

            'user_id' => User::factory(),

            'title' => fake()->randomElement([
                'Novo comentário',
                'Chamado resolvido',
                'Chamado atribuído',
                'Status alterado',
            ]),

            'message' => fake()->sentence(),

            'read' => false,

            'url' => '/tickets/1',
        ];
    }
}