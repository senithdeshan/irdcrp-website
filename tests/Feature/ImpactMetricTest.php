<?php

namespace Tests\Feature;

use App\Models\ImpactMetric;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImpactMetricTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_impact_metrics(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Total Beneficiaries')
            ->assertSee('57,500')
            ->assertSee('USD 105 Million')
            ->assertSee('Total Projects');
    }

    public function test_admin_can_update_impact_metrics(): void
    {
        $user = User::factory()->create();
        $metric = ImpactMetric::query()->where('key', 'beneficiaries')->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->put(route('admin.impact-metrics.update'), [
                'metrics' => [
                    $metric->id => [
                        'label' => 'Total Beneficiaries',
                        'value' => '60,000',
                        'count_target' => 60000,
                        'helper' => 'Updated beneficiary target.',
                        'sort_order' => 20,
                        'is_active' => 1,
                    ],
                ],
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.impact-metrics.index'));

        $this->assertDatabaseHas('impact_metrics', [
            'key' => 'beneficiaries',
            'value' => '60,000',
            'count_target' => 60000,
        ]);
    }
}
