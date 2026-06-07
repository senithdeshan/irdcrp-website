<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Support\PublicFileDownload;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        $items = Report::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('document_date')
            ->orderByDesc('id')
            ->get();

        return view('reports.index', compact('items'));
    }

    public function download(Report $report): Response|StreamedResponse
    {
        abort_unless($report->status === 'published', 404);
        abort_unless($report->documentExists(), 404);

        return PublicFileDownload::fromPublicDisk(
            $report->document_path,
            $report->document_original_name ?: basename($report->document_path),
        );
    }
}
