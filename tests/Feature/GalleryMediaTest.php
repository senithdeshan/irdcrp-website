<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_external_video_gallery_item(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('admin.gallery.store'), [
                'title' => 'Project field video',
                'category' => 'videos',
                'media_type' => 'video',
                'description' => 'A field update from the project area.',
                'item_date' => '2026-05-08',
                'status' => 'published',
                'external_url' => 'https://example.com/video',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseHas('galleries', [
            'title' => 'Project field video',
            'category' => 'videos',
            'media_type' => 'video',
            'status' => 'published',
            'external_url' => 'https://example.com/video',
        ]);
    }

    public function test_public_video_gallery_displays_published_items(): void
    {
        Gallery::create([
            'title' => 'Project field video',
            'category' => 'videos',
            'media_type' => 'video',
            'image' => 'https://example.com/video',
            'external_url' => 'https://example.com/video',
            'status' => 'published',
        ]);

        $this->get(route('gallery.section', 'videos'))
            ->assertOk()
            ->assertSee('Project field video');
    }
}
