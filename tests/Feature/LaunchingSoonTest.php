<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LaunchingSoonTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('web')->get('/launch-availability-test', fn () => 'Website is live.');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_public_site_shows_launch_page_before_launch_time(): void
    {
        config([
            'irdcrp.launching_soon.enabled' => true,
            'irdcrp.launching_soon.launch_at' => '2026-06-23 10:33:00',
            'irdcrp.launching_soon.timezone' => 'Asia/Colombo',
        ]);
        Carbon::setTestNow(Carbon::parse('2026-06-23 10:30:00', 'Asia/Colombo'));

        $response = $this->get('/launch-availability-test')
            ->assertStatus(503)
            ->assertSee('Launching soon.')
            ->assertSee('2026-06-23T10:33:00+05:30', false);

        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_public_site_is_available_at_launch_time(): void
    {
        config([
            'irdcrp.launching_soon.enabled' => true,
            'irdcrp.launching_soon.launch_at' => '2026-06-23 10:33:00',
            'irdcrp.launching_soon.timezone' => 'Asia/Colombo',
        ]);
        Carbon::setTestNow(Carbon::parse('2026-06-23 10:33:00', 'Asia/Colombo'));

        $this->get('/launch-availability-test')
            ->assertOk()
            ->assertSee('Website is live.')
            ->assertDontSee('Launching soon.');
    }
}
