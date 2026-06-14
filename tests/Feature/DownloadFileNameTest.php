<?php

namespace Tests\Feature;

use App\Models\Download;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DownloadFileNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_document_library_file_download_uses_original_file_name(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);
        Storage::fake('public');
        Storage::disk('public')->put('downloads/stored-file.pdf', 'document');

        $download = Download::create([
            'title' => 'Public Procurement Form',
            'description' => 'Downloadable PDF.',
            'file_path' => 'downloads/stored-file.pdf',
            'file_original_name' => 'Public Procurement Form.pdf',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $this->get(route('download.file', $download))
            ->assertOk()
            ->assertDownload('Public Procurement Form.pdf');
    }

    public function test_document_library_file_download_uses_title_when_original_name_is_missing(): void
    {
        config(['irdcrp.launching_soon.enabled' => false]);
        Storage::fake('public');
        Storage::disk('public')->put('downloads/random-hash.pdf', 'document');

        $download = Download::create([
            'title' => 'Readable Report Name',
            'description' => 'Downloadable PDF.',
            'file_path' => 'downloads/random-hash.pdf',
            'file_original_name' => null,
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $this->get(route('download.file', $download))
            ->assertOk()
            ->assertDownload('readable-report-name.pdf');
    }
}
