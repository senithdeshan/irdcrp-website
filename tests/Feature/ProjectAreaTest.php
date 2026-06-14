<?php

namespace Tests\Feature;

use App\Models\ProjectAreaDistrict;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectAreaTest extends TestCase
{
    use RefreshDatabase;

    public function test_areas_page_shows_district_rows_from_database(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        ProjectAreaDistrict::create([
            'district' => 'Gampaha',
            'ds_divisions' => 'Attanagalla, Gampaha',
            'focus' => 'Agriculture',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get('/areas')
            ->assertOk()
            ->assertSee('Gampaha')
            ->assertSee('Attanagalla, Gampaha');
    }

    public function test_super_admin_can_add_district_area(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $this->actingAs($user)
            ->post(route('admin.project-area-districts.store'), [
                'district' => 'Kandy',
                'ds_divisions' => 'Kandy, Harispattuwa',
                'focus' => 'Livestock',
                'sort_order' => 2,
                'is_active' => 1,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.project-areas.edit'));

        $this->assertDatabaseHas('project_area_districts', [
            'district' => 'Kandy',
            'is_active' => true,
        ]);
    }
}
