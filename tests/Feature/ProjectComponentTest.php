<?php

namespace Tests\Feature;

use App\Models\ProjectComponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_components_page_displays_seeded_project_components(): void
    {
        $response = $this->get('/components');

        $response
            ->assertOk()
            ->assertSee('Promotion of Climate-Smart Production')
            ->assertSee('Contingent Emergency Response Component');
    }

    public function test_admin_can_update_a_project_component(): void
    {
        $user = User::factory()->create();
        $component = ProjectComponent::query()->where('component_number', 5)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->put(route('admin.project-components.update', $component), [
                'component_number' => 5,
                'title' => 'Contingent Emergency Response Component',
                'budget' => 'US$0 million',
                'beneficiaries' => 'Emergency response beneficiaries',
                'description' => 'Updated response text for eligible crisis or emergency support.',
                'sort_order' => 5,
                'status' => 'published',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.project-components.index'));

        $this->assertDatabaseHas('project_components', [
            'id' => $component->id,
            'beneficiaries' => 'Emergency response beneficiaries',
            'description' => 'Updated response text for eligible crisis or emergency support.',
        ]);
    }
}
