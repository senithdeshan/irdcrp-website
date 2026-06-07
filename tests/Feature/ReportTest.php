<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_reports_page_displays_published_items(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        Report::query()->create([
            'title' => 'Annual progress report 2026',
            'description' => 'Year-end implementation summary.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('reports.index'));

        $response
            ->assertOk()
            ->assertSee('Reports')
            ->assertSee('Annual progress report 2026')
            ->assertSee('Year-end implementation summary.');
    }

    public function test_super_admin_can_create_report_with_files(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.reports.store'), [
                'title' => 'Monitoring report',
                'description' => 'Quarterly monitoring summary.',
                'document' => UploadedFile::fake()->create('monitoring.pdf', 120, 'application/pdf'),
                'images' => [
                    UploadedFile::fake()->image('chart.jpg'),
                ],
                'document_date' => '2026-06-01',
                'sort_order' => 2,
                'status' => 'published',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.reports.index'));

        $item = Report::query()->first();

        $this->assertNotNull($item);
        $this->assertTrue($item->documentExists());
        $this->assertCount(1, $item->images ?? []);
    }
}
