<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketAttachmentFactory extends Factory
{
    protected $model = TicketAttachment::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory(),
            'original_name' => fake()->word() . '.pdf',
            'file_path' => 'attachments/test.pdf',
            'comment_id' => null,
        ];
    }
}