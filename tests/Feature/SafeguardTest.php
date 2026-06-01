<?php

namespace Tests\Feature;

use App\Models\SafeguardResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SafeguardTest extends TestCase
{
    use RefreshDatabase;

    public function test_safeguard_page_displays_published_items_for_category(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        SafeguardResource::query()->create([
            'category' => 'social-management-plan-social-screening-report',
            'title' => 'Social screening report 2026',
            'description' => 'Annual social screening summary.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('safeguards.show', 'social-management-plan-social-screening-report'));

        $response
            ->assertOk()
            ->assertSee('Social Management Plan & Social Screening Report')
            ->assertSee('Social screening report 2026')
            ->assertSee('Annual social screening summary.');
    }

    public function test_super_admin_can_create_safeguard_item_with_files(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.safeguards.store'), [
                'category' => 'environment-management-plan-environment-screening-plan',
                'title' => 'Environment management plan',
                'description' => 'Approved EMP document.',
                'document' => UploadedFile::fake()->create('emp.pdf', 120, 'application/pdf'),
                'images' => [
                    UploadedFile::fake()->image('site.jpg'),
                ],
                'document_date' => '2026-06-01',
                'sort_order' => 3,
                'status' => 'published',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.safeguards.index'));

        $item = SafeguardResource::query()->first();

        $this->assertNotNull($item);
        $this->assertSame('environment-management-plan-environment-screening-plan', $item->category);
        $this->assertTrue($item->documentExists());
        $this->assertCount(1, $item->images ?? []);
    }
}
