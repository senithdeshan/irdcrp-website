<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_displays_default_content(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $response = $this->get('/about');

        $response
            ->assertOk()
            ->assertSee('About Us')
            ->assertSee('Our Mission')
            ->assertSee('Why Choose Us?');
    }

    public function test_super_admin_can_update_about_page_and_public_sees_published_content(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $payload = app(SiteSettings::class)->aboutPageDefaults();
        $payload['status'] = 'published';
        $payload['hero_title'] = 'About IRDCRP';
        $payload['mission_text'] = 'Updated mission statement for testing.';

        $response = $this
            ->actingAs($user)
            ->put(route('admin.about-page.update'), $payload);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.about-page.edit'));

        $this->get('/about')
            ->assertOk()
            ->assertSee('About IRDCRP')
            ->assertSee('Updated mission statement for testing.');
    }

    public function test_draft_about_page_changes_are_hidden_from_public_site(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $payload = app(SiteSettings::class)->aboutPageDefaults();
        $payload['status'] = 'draft';
        $payload['hero_title'] = 'Hidden draft title';

        $this
            ->actingAs($user)
            ->put(route('admin.about-page.update'), $payload)
            ->assertSessionHasNoErrors();

        $this->get('/about')
            ->assertOk()
            ->assertSee('About Us')
            ->assertDontSee('Hidden draft title');
    }
}
