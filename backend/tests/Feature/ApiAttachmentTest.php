<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;
use App\Models\TicketAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiAttachmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_attachments()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        TicketAttachment::factory()
            ->count(3)
            ->create([
                'ticket_id' => $ticket->id,
            ]);

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/attachments"
        );

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');
        
        $response->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);
    }

    public function test_authenticated_user_can_upload_attachment()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
        ]);

        $file = UploadedFile::fake()
            ->create(
                'manual.pdf',
                100,
                'application/pdf'
            );

        $response = $this->postJson(
            "/api/v1/tickets/{$ticket->id}/attachments",
            [
                'file' => $file,
            ]
        );

        $response->assertStatus(201);

        $this->assertDatabaseCount(
            'ticket_attachments',
            1
        );
    }

    public function test_guest_cannot_upload_attachment()
    {
        $ticket = Ticket::factory()->create();

        $file = UploadedFile::fake()
            ->create(
                'manual.pdf',
                100
            );

        $response = $this->postJson(
            "/api/v1/tickets/{$ticket->id}/attachments",
            [
                'file' => $file,
            ]
        );

        $response->assertStatus(401);
    }

    public function test_user_cannot_view_other_users_attachments()
    {
        $owner = User::factory()->create();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id' => $owner->id,
        ]);

        $response = $this->getJson(
            "/api/v1/tickets/{$ticket->id}/attachments"
        );

        $response->assertStatus(403);
    }
}