<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'title' => fake()->sentence(),

            'description' => fake()->paragraph(),

            'category' => fake()->randomElement([
                'hardware',
                'software',
                'network',
                'access',
                'other',
            ]),

            'priority' => fake()->randomElement([
                'low',
                'medium',
                'high',
                'critical',
            ]),

            'status' => 'open',

            'user_id' => \App\Models\User::factory(),

        ];
    }
}
