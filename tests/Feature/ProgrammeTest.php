<?php

namespace Tests\Feature;

use App\Models\Programme;
use App\Models\ProjectComponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProgrammeTest extends TestCase
{
    use RefreshDatabase;

    private function componentOneId(): int
    {
        return (int) ProjectComponent::query()->where('component_number', 1)->value('id');
    }

    public function test_programmes_page_displays_seeded_programmes(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $this->get(route('programmes.index'))
            ->assertOk()
            ->assertSee('Climate Smart Agronomic Improvements Programme');
    }

    public function test_programmes_page_filters_by_component(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $componentOne = ProjectComponent::query()->where('component_number', 1)->firstOrFail();
        $componentTwo = ProjectComponent::query()->where('component_number', 2)->firstOrFail();

        Programme::query()->update(['project_component_id' => $componentOne->id]);

        Programme::query()->firstOrFail()->update(['project_component_id' => $componentTwo->id]);

        $this->get(route('programmes.index', ['component' => 2]))
            ->assertOk()
            ->assertSee('Component 2')
            ->assertSee(Programme::query()->where('project_component_id', $componentTwo->id)->value('title'));
    }

    public function test_admin_can_create_programme(): void
    {
        Storage::fake('public');
        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.programmes.store'), [
                'title' => 'New Field Programme',
                'slug' => 'new-field-programme',
                'project_component_id' => $this->componentOneId(),
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

    public function test_admin_can_create_programme_with_content_blocks(): void
    {
        Storage::fake('public');
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.programmes.store'), [
                'title' => 'Extended Field Programme',
                'slug' => 'extended-field-programme',
                'project_component_id' => $this->componentOneId(),
                'summary' => 'Short field summary.',
                'description' => 'Intro description.',
                'sort_order' => 11,
                'status' => 'published',
                'image' => UploadedFile::fake()->image('cover.jpg', 1200, 800),
                'blocks' => [
                    [
                        'type' => 'text',
                        'body' => 'Detailed programme section text.',
                    ],
                    [
                        'type' => 'table',
                        'title' => 'Targets',
                        'headers_text' => 'District|Beneficiaries',
                        'rows_text' => "Ampara|1200\nBatticaloa|900",
                    ],
                ],
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.programmes.index'));

        $programme = Programme::query()->where('slug', 'extended-field-programme')->first();

        $this->assertNotNull($programme);
        $this->assertCount(2, $programme->content_blocks ?? []);
        $this->assertSame('table', $programme->content_blocks[1]['type']);

        $this->get(route('programmes.show', $programme))
            ->assertOk()
            ->assertSee('Detailed programme section text.')
            ->assertSee('Targets')
            ->assertSee('Ampara');
    }

    public function test_programme_detail_page_displays_programme(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $programme = Programme::query()->firstOrFail();

        $this->get(route('programmes.show', $programme))
            ->assertOk()
            ->assertSee($programme->title);
    }
}
