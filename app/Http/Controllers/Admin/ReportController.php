<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $items = Report::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.reports.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.reports.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['document_path'] = null;
        $data['document_original_name'] = null;
        $data['document_mime'] = null;
        $data['images'] = [];

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $data['document_path'] = $file->store('reports/documents', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        if ($request->hasFile('images')) {
            $data['images'] = collect($request->file('images'))
                ->map(fn ($image): string => $image->store('reports/images', 'public'))
                ->values()
                ->all();
        }

        unset($data['document']);

        Report::create($data);

        return redirect()->route('admin.reports.index')->with('success', 'Report item created.');
    }

    public function edit(Report $report): View
    {
        return view('admin.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $data = $this->validatedData($request);
        $images = $report->images ?? [];
        $removeImages = array_filter((array) $request->input('remove_images', []));

        if ($removeImages !== []) {
            foreach ($removeImages as $path) {
                Storage::disk('public')->delete($path);
            }
            $images = array_values(array_diff($images, $removeImages));
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('reports/images', 'public');
            }
        }

        if ($request->hasFile('document')) {
            if ($report->document_path) {
                Storage::disk('public')->delete($report->document_path);
            }

            $file = $request->file('document');
            $data['document_path'] = $file->store('reports/documents', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        $data['images'] = array_values($images);
        unset($data['document']);

        $report->update($data);

        return redirect()->route('admin.reports.index')->with('success', 'Report item updated.');
    }

    public function destroy(Report $report): RedirectResponse
    {
        if ($report->document_path) {
            Storage::disk('public')->delete($report->document_path);
        }

        foreach ($report->images ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }

        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Report item removed.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'document' => ['nullable', 'file', 'max:51200', 'mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,zip'],
            'document_date' => ['nullable', 'date'],
            'images' => ['nullable', 'array', 'max:12'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_images' => ['nullable', 'array'],
            'status' => ['required', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
