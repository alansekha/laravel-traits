<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComplaintTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_relation_complaint()
    {
        $complaint = Complaint::factory()->create();

        $this->assertNotNull($complaint->user);
    }

    public function test_create_complaint()
    {
        Storage::fake('local');
        $user = User::factory()->create();

        $file = File::create('image.jpg');
        $response = $this->post(route('complaint.create'), [
            'user_id' => $user->id,
            'description' => $this->faker()->sentence(),
            'file' => $file
        ]);
        $response->assertStatus(200);

        $complaint = Complaint::first();
        Storage::disk('local')->assertExists($complaint->path);
    }
}
