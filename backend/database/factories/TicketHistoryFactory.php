<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketHistoryFactory extends Factory
{
    protected $model = TicketHistory::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory(),
            'action' => 'created',
            'description' => fake()->sentence(),
        ];
    }
}