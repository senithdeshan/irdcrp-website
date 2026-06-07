<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(): View
    {
        $items = Download::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.downloads.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.downloads.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, true);
        $file = $request->file('file');
        $data['file_path'] = $file->store('downloads', 'public');
        $data['file_original_name'] = $file->getClientOriginalName();
        unset($data['file']);
        Download::create($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Document created.');
    }

    public function edit(Download $download): View
    {
        return view('admin.downloads.edit', compact('download'));
    }

    public function update(Request $request, Download $download): RedirectResponse
    {
        $data = $this->validatedData($request, false);
        unset($data['file']);

        if ($request->hasFile('file')) {
            if ($download->file_path) {
                Storage::disk('public')->delete($download->file_path);
            }

            $file = $request->file('file');
            $data['file_path'] = $file->store('downloads', 'public');
            $data['file_original_name'] = $file->getClientOriginalName();
        }

        $download->update($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Document updated.');
    }

    public function destroy(Download $download): RedirectResponse
    {
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }
        $download->delete();

        return redirect()->route('admin.downloads.index')->with('success', 'Document removed.');
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
