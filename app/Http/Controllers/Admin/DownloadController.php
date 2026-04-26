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
        $data['file_path'] = $request->file('file')->store('downloads', 'public');
        unset($data['file']);
        Download::create($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Download item created.');
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
            $data['file_path'] = $request->file('file')->store('downloads', 'public');
        }

        $download->update($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Download item updated.');
    }

    public function destroy(Download $download): RedirectResponse
    {
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }
        $download->delete();

        return redirect()->route('admin.downloads.index')->with('success', 'Download item removed.');
    }

    private function validatedData(Request $request, bool $requireFile): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'file_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0|max:65535',
        ];
        $rules['file'] = $requireFile
            ? 'required|file|max:25600|mimes:pdf,doc,docx,xls,xlsx,zip'
            : 'nullable|file|max:25600|mimes:pdf,doc,docx,xls,xlsx,zip';

        $data = $request->validate($rules);
        if (! array_key_exists('sort_order', $data) || $data['sort_order'] === null) {
            $data['sort_order'] = 0;
        }

        return $data;
    }
}
