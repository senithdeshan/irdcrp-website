<?php

namespace Tests\Feature;

use App\Models\GrmComplaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrmComplaintAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_mark_grm_complaint_as_solved(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $complaint = GrmComplaint::create([
            'name' => 'Citizen One',
            'email' => 'citizen@example.com',
            'message' => 'Road issue near project area.',
            'status' => 'new',
        ]);

        $this
            ->actingAs($user)
            ->put(route('admin.grm-complaints.update', $complaint), [
                'status' => 'solved',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.grm-complaints.index'));

        $complaint->refresh();

        $this->assertSame('solved', $complaint->status);
        $this->assertNotNull($complaint->resolved_at);
        $this->assertSame(1, GrmComplaint::summaryStats()['solved']);
    }

    public function test_super_admin_can_delete_grm_complaint(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $complaint = GrmComplaint::create([
            'name' => 'Citizen Two',
            'email' => 'citizen-two@example.com',
            'message' => 'Water supply issue.',
            'status' => 'new',
        ]);

        $this
            ->actingAs($user)
            ->delete(route('admin.grm-complaints.destroy', $complaint))
            ->assertRedirect(route('admin.grm-complaints.index'));

        $this->assertDatabaseMissing('grm_complaints', [
            'id' => $complaint->id,
        ]);
        $this->assertSame(0, GrmComplaint::summaryStats()['total']);
    }
}
