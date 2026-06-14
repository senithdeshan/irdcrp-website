<?php

namespace Tests\Feature;

use App\Models\KeyLeader;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrganizationalStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizational_structure_page_shows_governance_chart_image(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        SiteSetting::create([
            'key' => 'organizational_structure',
            'value' => json_encode([
                'section_title' => 'Organizational Structure',
                'section_subtitle' => 'Project implementation and reporting structure.',
                'image' => 'storage/organizational-structure/example.jpg',
                'image_alt' => 'IRDCRP organizational structure',
                'staff_fallback_image' => null,
                'staff_fallback_image_alt' => 'IRDCRP project staff',
            ]),
        ]);

        $this->get(route('organizational-structure'))
            ->assertOk()
            ->assertSee('Governance chart')
            ->assertSee('storage/organizational-structure/example.jpg');
    }

    public function test_staff_fallback_image_is_hidden_when_project_staff_profiles_exist(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        SiteSetting::create([
            'key' => 'organizational_structure',
            'value' => json_encode([
                'section_title' => 'Organizational Structure',
                'section_subtitle' => 'Project implementation and reporting structure.',
                'image' => null,
                'image_alt' => 'IRDCRP organizational structure',
                'staff_fallback_image' => 'storage/organizational-structure/staff-template.png',
                'staff_fallback_image_alt' => 'Project staff template',
            ]),
        ]);

        KeyLeader::create([
            'group' => 'project_staff',
            'is_active' => true,
            'sort_order' => 1,
            'image' => 'storage/key-leaders/test.png',
            'role_en' => 'Project Officer',
            'org_en' => 'IRDCRP PMU',
        ]);

        $this->get(route('organizational-structure'))
            ->assertOk()
            ->assertDontSee('storage/organizational-structure/staff-template.png', false);
    }

    public function test_super_admin_can_delete_organizational_structure_images(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);
        Storage::fake('public');
        Storage::disk('public')->put('organizational-structure/chart.jpg', 'chart');
        Storage::disk('public')->put('organizational-structure/staff.png', 'staff');

        SiteSetting::create([
            'key' => 'organizational_structure',
            'value' => json_encode([
                'section_title' => 'Organizational Structure',
                'section_subtitle' => 'Project implementation and reporting structure.',
                'image' => 'storage/organizational-structure/chart.jpg',
                'image_alt' => 'IRDCRP organizational structure',
                'staff_fallback_image' => 'storage/organizational-structure/staff.png',
                'staff_fallback_image_alt' => 'Project staff template',
            ]),
        ]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $this
            ->actingAs($user)
            ->put(route('admin.organizational-structure.update'), [
                'section_title' => 'Organizational Structure',
                'section_subtitle' => 'Project implementation and reporting structure.',
                'image_alt' => 'IRDCRP organizational structure',
                'remove_structure_image' => 1,
                'staff_fallback_image_alt' => 'Project staff template',
                'remove_staff_fallback_image' => 1,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.organizational-structure.edit'));

        $structure = json_decode(SiteSetting::where('key', 'organizational_structure')->value('value'), true);

        $this->assertNull($structure['image']);
        $this->assertNull($structure['staff_fallback_image']);
        Storage::disk('public')->assertMissing('organizational-structure/chart.jpg');
        Storage::disk('public')->assertMissing('organizational-structure/staff.png');
    }
}
