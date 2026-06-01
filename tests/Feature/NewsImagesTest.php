<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_upload_multiple_news_images(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.news.store'), [
                'title_en' => 'Multiple image news',
                'content_en' => 'This news item has several uploaded images.',
                'published_date' => '2026-06-01',
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->image('one.jpg'),
                    UploadedFile::fake()->image('two.jpg'),
                    UploadedFile::fake()->image('three.jpg'),
                    UploadedFile::fake()->image('four.jpg'),
                    UploadedFile::fake()->image('five.jpg'),
                    UploadedFile::fake()->image('six.jpg'),
                ],
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.news.index'));

        $news = News::query()->where('title_en', 'Multiple image news')->firstOrFail();

        $this->assertCount(6, $news->imagePaths());
        $this->assertSame($news->imagePaths()[0], $news->image);

        foreach ($news->imagePaths() as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }

    public function test_public_news_page_uses_uploaded_image_urls(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $news = News::query()->create([
            'title_en' => 'Rendered image news',
            'content_en' => 'Uploaded image paths should render on the website.',
            'published_date' => '2026-06-01',
            'status' => 'published',
            'image' => 'news/cover.jpg',
            'images' => ['news/cover.jpg', 'news/detail.jpg'],
        ]);

        $this->get(route('news.show', $news))
            ->assertOk()
            ->assertSee('/storage/news/cover.jpg', false)
            ->assertSee('/storage/news/detail.jpg', false);
    }
}
