<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CercDocument;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CercDocumentController extends Controller
{
    public function index(SiteSettings $settings): View
    {
        $items = CercDocument::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.cerc-documents.index', [
            'items' => $items,
            'cerc' => $settings->cercPage(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cerc-documents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, true);
        $file = $request->file('file');
        $data['file_path'] = $file->store('cerc-documents', 'public');
        $data['file_original_name'] = $file->getClientOriginalName();
        unset($data['file']);

        CercDocument::create($data);

        return redirect()->route('admin.cerc-documents.index')->with('success', 'CERC document created.');
    }

    public function edit(CercDocument $cercDocument): View
    {
        return view('admin.cerc-documents.edit', compact('cercDocument'));
    }

    public function update(Request $request, CercDocument $cercDocument): RedirectResponse
    {
        $data = $this->validatedData($request, false);
        unset($data['file']);

        if ($request->hasFile('file')) {
            if ($cercDocument->file_path) {
                Storage::disk('public')->delete($cercDocument->file_path);
            }

            $file = $request->file('file');
            $data['file_path'] = $file->store('cerc-documents', 'public');
            $data['file_original_name'] = $file->getClientOriginalName();
        }

        $cercDocument->update($data);

        return redirect()->route('admin.cerc-documents.index')->with('success', 'CERC document updated.');
    }

    public function updateSettings(Request $request, SiteSettings $settings): RedirectResponse
    {
        $data = $request->validate([
            'hero_eyebrow' => ['required', 'string', 'max:120'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_lead' => ['required', 'string', 'max:1000'],
            'summary_label' => ['required', 'string', 'max:160'],
            'summary_copy' => ['required', 'string', 'max:1500'],
            'document_section_title' => ['required', 'string', 'max:255'],
            'document_section_description' => ['required', 'string', 'max:1000'],
        ]);

        $settings->putCercPage($data);

        return redirect()->route('admin.cerc-documents.index')->with('success', 'CERC page settings updated.');
    }

    public function destroy(CercDocument $cercDocument): RedirectResponse
    {
        if ($cercDocument->file_path) {
            Storage::disk('public')->delete($cercDocument->file_path);
        }

        $cercDocument->delete();

        return redirect()->route('admin.cerc-documents.index')->with('success', 'CERC document removed.');
    }

    private function validatedData(Request $request, bool $requireFile): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'file_date' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ];
        $rules['file'] = $requireFile
            ? ['required', 'file', 'max:51200', 'mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,zip']
            : ['nullable', 'file', 'max:51200', 'mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,zip'];

        $data = $request->validate($rules);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
