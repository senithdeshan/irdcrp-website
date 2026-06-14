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
        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

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
        config(['irdcrp.launching_soon.enabled' => false]);

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

    public function test_pinned_photos_appear_first_on_public_gallery(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $olderPinned = Gallery::create([
            'title' => 'Pinned hero photo',
            'category' => 'photos',
            'media_type' => 'image',
            'image' => 'gallery/photos/pinned.jpg',
            'file_path' => 'gallery/photos/pinned.jpg',
            'status' => 'published',
            'is_pinned' => true,
            'item_date' => '2026-01-01',
        ]);

        Gallery::create([
            'title' => 'Newer regular photo',
            'category' => 'photos',
            'media_type' => 'image',
            'image' => 'gallery/photos/newer.jpg',
            'file_path' => 'gallery/photos/newer.jpg',
            'status' => 'published',
            'item_date' => '2026-06-01',
        ]);

        $response = $this->get(route('gallery.section', 'photos'));

        $response
            ->assertOk()
            ->assertSee('Pinned hero photo')
            ->assertSee('Newer regular photo')
            ->assertSeeInOrder(['Pinned hero photo', 'Newer regular photo']);
    }

    public function test_admin_pinning_is_limited_to_three_per_category(): void
    {
        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $items = collect();

        foreach (range(1, 3) as $number) {
            $items->push(Gallery::create([
                'title' => "Pinned photo {$number}",
                'category' => 'photos',
                'media_type' => 'image',
                'image' => "gallery/photos/pin-{$number}.jpg",
                'file_path' => "gallery/photos/pin-{$number}.jpg",
                'status' => 'published',
                'is_pinned' => true,
                'item_date' => "2026-01-0{$number}",
            ]));
        }

        $fourth = Gallery::create([
            'title' => 'Fourth photo',
            'category' => 'photos',
            'media_type' => 'image',
            'image' => 'gallery/photos/fourth.jpg',
            'file_path' => 'gallery/photos/fourth.jpg',
            'status' => 'published',
            'item_date' => '2026-06-07',
        ]);

        $this
            ->actingAs($user)
            ->post(route('admin.gallery.toggle-pin', $fourth), ['category' => 'photos'])
            ->assertRedirect(route('admin.gallery.index', ['category' => 'photos']))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('galleries', [
            'id' => $fourth->id,
            'is_pinned' => true,
        ]);

        $this->assertSame(3, Gallery::query()->where('category', 'photos')->where('is_pinned', true)->count());
        $this->assertDatabaseHas('galleries', [
            'title' => 'Pinned photo 1',
            'is_pinned' => false,
        ]);
    }
}
