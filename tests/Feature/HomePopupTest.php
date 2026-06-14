<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePopupTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_popup_renders_on_home_page_only(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        SiteSetting::create([
            'key' => 'home_popup',
            'value' => json_encode([
                'enabled' => true,
                'image' => 'storage/home-popup/notice.jpg',
                'link_url' => 'https://example.com/notice',
                'alt' => 'Important notice',
                'updated_at' => '2026-06-14T10:00:00+00:00',
            ]),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('id="irdc-home-popup"', false)
            ->assertSee('localStorage', false)
            ->assertSee('data-popup-link', false);

        $this->get('/about')
            ->assertOk()
            ->assertDontSee('id="irdc-home-popup"', false);
    }
}
