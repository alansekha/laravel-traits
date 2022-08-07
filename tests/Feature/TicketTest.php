<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_relation_ticket()
    {
        $ticket = Ticket::factory()->create();

        $this->assertNotNull($ticket->user);
    }

    public function test_create_ticket()
    {
        Storage::fake('local');
        $user = User::factory()->create();

        $file = File::create('image.jpg');
        $response = $this->post(route('ticket.create'), [
            'user_id' => $user->id,
            'description' => $this->faker()->sentence(),
            'file' => $file
        ]);
        $response->assertStatus(200);

        $ticket = Ticket::first();
        Storage::disk('local')->assertExists($ticket->path);
    }
}
