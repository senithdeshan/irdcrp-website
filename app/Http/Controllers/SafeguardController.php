<?php

namespace App\Http\Controllers;

use App\Models\SafeguardResource;
use App\Support\PublicFileDownload;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SafeguardController extends Controller
{
    public function show(string $category): View
    {
        abort_unless(array_key_exists($category, SafeguardResource::CATEGORIES), 404);

        $items = SafeguardResource::query()
            ->where('category', $category)
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('safeguards.show', [
            'category' => $category,
            'categoryTitle' => SafeguardResource::CATEGORIES[$category],
            'items' => $items,
        ]);
    }

    public function download(SafeguardResource $safeguard): Response|StreamedResponse
    {
        abort_unless($safeguard->status === 'published', 404);
        abort_unless($safeguard->documentExists(), 404);

        return PublicFileDownload::fromPublicDisk(
            $safeguard->document_path,
            $safeguard->document_original_name ?: basename($safeguard->document_path),
        );
    }
}
