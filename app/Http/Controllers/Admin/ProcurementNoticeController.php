<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcurementNotice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProcurementNoticeController extends Controller
{
    public function index(): View
    {
        $items = ProcurementNotice::query()
            ->orderBy('sort_order')
            ->orderByDesc('published_date')
            ->orderByDesc('id')
            ->get();

        return view('admin.procurement-notices.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.procurement-notices.create', [
            'notice' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['documents'] = $this->uploadedDocuments($request);

        ProcurementNotice::create($data);

        return redirect()->route('admin.procurement-notices.index')->with('success', 'Procurement notice created.');
    }

    public function edit(ProcurementNotice $procurementNotice): View
    {
        return view('admin.procurement-notices.edit', [
            'notice' => $procurementNotice,
        ]);
    }

    public function update(Request $request, ProcurementNotice $procurementNotice): RedirectResponse
    {
        $data = $this->validatedData($request);
        $documents = $procurementNotice->documents ?? [];

        $removeIndexes = collect($request->input('remove_documents', []))
            ->map(fn ($index): int => (int) $index)
            ->all();

        foreach ($removeIndexes as $index) {
            if (isset($documents[$index]['path'])) {
                Storage::disk('public')->delete($documents[$index]['path']);
                unset($documents[$index]);
            }
        }

        $documents = array_values($documents);
        $documents = array_merge($documents, $this->uploadedDocuments($request));
        $data['documents'] = $documents;

        $procurementNotice->update($data);

        return redirect()->route('admin.procurement-notices.index')->with('success', 'Procurement notice updated.');
    }

    public function destroy(ProcurementNotice $procurementNotice): RedirectResponse
    {
        foreach ($procurementNotice->documents ?? [] as $document) {
            if (filled($document['path'] ?? null)) {
                Storage::disk('public')->delete($document['path']);
            }
        }

        $procurementNotice->delete();

        return redirect()->route('admin.procurement-notices.index')->with('success', 'Procurement notice deleted.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'reference_no' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'notice_type' => ['required', 'in:notice,bidding,award,report,other'],
            'published_date' => ['nullable', 'date'],
            'closing_date' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,open,closed'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'documents' => ['nullable', 'array', 'max:6'],
            'documents.*' => ['nullable', 'file', 'mimes:pdf', 'max:51200'],
            'document_labels' => ['nullable', 'array'],
            'document_labels.*' => ['nullable', 'string', 'max:160'],
            'remove_documents' => ['nullable', 'array'],
            'remove_documents.*' => ['integer', 'min:0'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['documents'], $data['document_labels'], $data['remove_documents']);

        return $data;
    }

    private function uploadedDocuments(Request $request): array
    {
        $documents = [];
        $labels = $request->input('document_labels', []);

        foreach ($request->file('documents', []) as $index => $file) {
            if (! $file) {
                continue;
            }

            $documents[] = [
                'label' => ($labels[$index] ?? null) ?: 'Procurement PDF',
                'path' => $file->store('procurement-notices', 'public'),
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ];
        }

        return $documents;
    }
}
