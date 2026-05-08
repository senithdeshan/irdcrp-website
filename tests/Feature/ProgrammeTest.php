<?php

namespace Tests\Feature;

use App\Models\Programme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProgrammeTest extends TestCase
{
    use RefreshDatabase;

    public function test_programmes_page_displays_seeded_programmes(): void
    {
        $this->get(route('programmes.index'))
            ->assertOk()
            ->assertSee('Climate Smart Agronomic Improvements Programme');
    }

    public function test_admin_can_create_programme(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('admin.programmes.store'), [
                'title' => 'New Field Programme',
                'slug' => 'new-field-programme',
                'summary' => 'Short field summary.',
                'description' => 'Longer field programme description.',
                'sort_order' => 10,
                'status' => 'published',
                'image' => UploadedFile::fake()->image('programme.jpg', 1200, 800),
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.programmes.index'));

        $this->assertDatabaseHas('programmes', [
            'title' => 'New Field Programme',
            'slug' => 'new-field-programme',
            'status' => 'published',
        ]);
    }

    public function test_programme_detail_page_displays_programme(): void
    {
        $programme = Programme::query()->firstOrFail();

        $this->get(route('programmes.show', $programme))
            ->assertOk()
            ->assertSee($programme->title);
    }
}
