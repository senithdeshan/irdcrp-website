<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    public function test_faq_page_displays_published_faqs(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        Faq::query()->create([
            'question' => 'How are FAQ answers managed?',
            'answer' => 'They are managed from the admin FAQ content screen.',
            'sort_order' => 99,
            'status' => 'published',
        ]);

        $response = $this->get('/faq');

        $response
            ->assertOk()
            ->assertSee('Frequently Asked Questions')
            ->assertSee('Integrated Rurban Development and Climate Resilience Project')
            ->assertSee('How are FAQ answers managed?');
    }

    public function test_super_admin_can_create_faq_item(): void
    {
        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.faqs.store'), [
                'question' => 'Can admins add new FAQ items?',
                'answer' => 'Yes, admins can create and publish FAQ answers.',
                'sort_order' => 7,
                'status' => 'published',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.faqs.index'));

        $this->assertDatabaseHas('faqs', [
            'question' => 'Can admins add new FAQ items?',
            'status' => 'published',
        ]);
    }
}
