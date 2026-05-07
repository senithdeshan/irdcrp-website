<?php

namespace Tests\Feature;

use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submits_a_support_message(): void
    {
        $response = $this->post(route('support-messages.store'), [
            'name' => 'Public User',
            'email' => 'public@example.com',
            'phone' => '011 123 4567',
            'subject' => 'Project question',
            'message' => 'Please send more information about the project.',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/contact');

        $this->assertDatabaseHas('support_messages', [
            'name' => 'Public User',
            'email' => 'public@example.com',
            'subject' => 'Project question',
            'status' => 'new',
        ]);
    }

    public function test_admin_can_update_a_support_message_status_and_reply(): void
    {
        $user = User::factory()->create();
        $message = SupportMessage::create([
            'name' => 'Public User',
            'email' => 'public@example.com',
            'subject' => 'Project question',
            'message' => 'Please send more information about the project.',
            'status' => 'new',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('admin.support-messages.update', $message), [
                'status' => 'resolved',
                'admin_reply' => 'Thank you. The project team will contact you.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.support-messages.index'));

        $message->refresh();

        $this->assertSame('resolved', $message->status);
        $this->assertSame('Thank you. The project team will contact you.', $message->admin_reply);
        $this->assertNotNull($message->resolved_at);
    }
}
