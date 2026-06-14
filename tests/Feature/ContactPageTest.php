<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_displays_default_content(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('pmuirdcrp@gmail.com')
            ->assertSee('Drop us a message for any query');
    }

    public function test_super_admin_can_update_contact_page(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $defaults = app(SiteSettings::class)->contactPageDefaults();

        $response = $this
            ->actingAs($user)
            ->put(route('admin.contact-page.update'), [
                'emails_raw' => "new.contact@irdcrp.lk\nsecond@irdcrp.lk",
                'phone' => '011 1111 111',
                'fax' => '011 2222 222',
                'website_url' => 'https://www.example.lk',
                'website_label' => 'www.example.lk',
                'address' => 'Updated address line',
                'form_title' => 'Write to us',
                'form_subtitle' => 'We reply within two working days.',
                'location_title' => $defaults['location']['title'],
                'location_unit' => $defaults['location']['unit'],
                'location_project' => $defaults['location']['project'],
                'location_place_name' => $defaults['location']['place_name'],
                'location_latitude' => $defaults['location']['latitude'],
                'location_longitude' => $defaults['location']['longitude'],
                'location_map_zoom' => $defaults['location']['map_zoom'],
                'location_maps_url' => $defaults['location']['maps_url'],
                'location_image_caption' => $defaults['location']['image_caption'],
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.contact-page.edit'));

        $this->get('/contact')
            ->assertOk()
            ->assertSee('new.contact@irdcrp.lk')
            ->assertSee('second@irdcrp.lk')
            ->assertSee('Write to us')
            ->assertSee('Updated address line');
    }
}
