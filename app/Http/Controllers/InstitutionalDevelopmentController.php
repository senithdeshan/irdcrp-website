<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalDevelopment;
use App\Support\PublicFileDownload;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InstitutionalDevelopmentController extends Controller
{
    public function index(): View
    {
        $items = InstitutionalDevelopment::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('document_date')
            ->orderByDesc('id')
            ->get();

        return view('institutional-development.index', compact('items'));
    }

    public function download(InstitutionalDevelopment $institutionalDevelopment): Response|StreamedResponse
    {
        abort_unless($institutionalDevelopment->status === 'published', 404);
        abort_unless($institutionalDevelopment->documentExists(), 404);

        return PublicFileDownload::fromPublicDisk(
            $institutionalDevelopment->document_path,
            $institutionalDevelopment->document_original_name ?: basename($institutionalDevelopment->document_path),
        );
    }
}
