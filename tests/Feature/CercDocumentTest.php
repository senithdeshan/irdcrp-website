<?php

namespace Tests\Feature;

use App\Models\CercDocument;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CercDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_cerc_page_displays_published_documents(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);
        Storage::fake('public');
        Storage::disk('public')->put('cerc-documents/manual.pdf', 'document');

        CercDocument::create([
            'title' => 'CERC Operations Manual',
            'description' => 'Emergency response procedures.',
            'file_path' => 'cerc-documents/manual.pdf',
            'file_original_name' => 'manual.pdf',
            'file_date' => '2026-06-01',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        CercDocument::create([
            'title' => 'Draft CERC Note',
            'file_path' => 'cerc-documents/draft.pdf',
            'status' => 'draft',
        ]);

        $this->get(route('cerc'))
            ->assertOk()
            ->assertSee('CERC document library')
            ->assertSee('CERC Operations Manual')
            ->assertSee('Emergency response procedures.')
            ->assertDontSee('Draft CERC Note');
    }

    public function test_super_admin_can_add_cerc_document(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);
        Storage::fake('public');

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $this
            ->actingAs($user)
            ->post(route('admin.cerc-documents.store'), [
                'title' => 'Emergency Form',
                'description' => 'Form for CERC emergency activation.',
                'file' => UploadedFile::fake()->create('emergency-form.pdf', 120, 'application/pdf'),
                'file_date' => '2026-06-01',
                'status' => 'published',
                'sort_order' => 2,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.cerc-documents.index'));

        $document = CercDocument::first();

        $this->assertSame('Emergency Form', $document->title);
        $this->assertSame('emergency-form.pdf', $document->file_original_name);
        $this->assertTrue($document->fileExists());
    }

    public function test_cerc_file_download_uses_original_file_name(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);
        Storage::fake('public');
        Storage::disk('public')->put('cerc-documents/stored-file.pdf', 'document');

        $document = CercDocument::create([
            'title' => 'CERC Manual',
            'file_path' => 'cerc-documents/stored-file.pdf',
            'file_original_name' => 'CERC Manual Final.pdf',
            'status' => 'published',
        ]);

        $this->get(route('cerc.file', $document))
            ->assertOk()
            ->assertDownload('CERC Manual Final.pdf');
    }

    public function test_super_admin_can_update_cerc_page_content(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);

        $user = User::factory()->create([
            'email' => config('irdcrp.super_admin.login'),
        ]);

        $this
            ->actingAs($user)
            ->put(route('admin.cerc-documents.settings.update'), [
                'hero_eyebrow' => 'CERC resources',
                'hero_title' => 'Emergency Response Documents',
                'hero_lead' => 'Updated public CERC page introduction.',
                'summary_label' => 'Rapid response',
                'summary_copy' => 'Updated CERC summary text.',
                'document_section_title' => 'Emergency document library',
                'document_section_description' => 'Updated document section description.',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.cerc-documents.index'));

        $this->get(route('cerc'))
            ->assertOk()
            ->assertSee('Emergency Response Documents')
            ->assertSee('Updated public CERC page introduction.')
            ->assertSee('Emergency document library');
    }
}
