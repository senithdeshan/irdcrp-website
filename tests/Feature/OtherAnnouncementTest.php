<?php

namespace Tests\Feature;

use App\Models\OtherAnnouncement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OtherAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_other_announcements_page_lists_published_items(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        OtherAnnouncement::query()->create([
            'title' => 'Community awareness notice',
            'description' => 'General announcement for partner communities.',
            'status' => 'published',
            'sort_order' => 1,
            'published_date' => '2026-06-01',
        ]);

        $response = $this->get(route('other-announcements.index'));

        $response
            ->assertOk()
            ->assertSee('Other')
            ->assertSee('Community awareness notice');
    }

    public function test_super_admin_can_create_other_announcement(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.other-announcements.store'), [
                'title' => 'Office closure notice',
                'description' => 'The PMU office will be closed on the listed date.',
                'document' => UploadedFile::fake()->create('notice.pdf', 100, 'application/pdf'),
                'published_date' => '2026-06-01',
                'sort_order' => 2,
                'status' => 'published',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.other-announcements.index'));

        $this->assertDatabaseHas('other_announcements', [
            'title' => 'Office closure notice',
            'status' => 'published',
        ]);
    }

    public function test_draft_other_announcement_is_hidden_from_public_site(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        OtherAnnouncement::query()->create([
            'title' => 'Hidden draft notice',
            'description' => 'Should not appear publicly.',
            'status' => 'draft',
        ]);

        $this->get(route('other-announcements.index'))
            ->assertOk()
            ->assertDontSee('Hidden draft notice');
    }
}
