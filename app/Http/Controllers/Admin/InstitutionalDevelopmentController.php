<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionalDevelopment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InstitutionalDevelopmentController extends Controller
{
    public function index(): View
    {
        $items = InstitutionalDevelopment::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.institutional-developments.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.institutional-developments.create');
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
            $data['document_path'] = $file->store('institutional-development/documents', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        if ($request->hasFile('images')) {
            $data['images'] = collect($request->file('images'))
                ->map(fn ($image): string => $image->store('institutional-development/images', 'public'))
                ->values()
                ->all();
        }

        unset($data['document']);

        InstitutionalDevelopment::create($data);

        return redirect()->route('admin.institutional-developments.index')->with('success', 'Item created.');
    }

    public function edit(InstitutionalDevelopment $institutionalDevelopment): View
    {
        return view('admin.institutional-developments.edit', [
            'item' => $institutionalDevelopment,
        ]);
    }

    public function update(Request $request, InstitutionalDevelopment $institutionalDevelopment): RedirectResponse
    {
        $data = $this->validatedData($request);
        $images = $institutionalDevelopment->images ?? [];
        $removeImages = array_filter((array) $request->input('remove_images', []));

        if ($removeImages !== []) {
            foreach ($removeImages as $path) {
                Storage::disk('public')->delete($path);
            }
            $images = array_values(array_diff($images, $removeImages));
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('institutional-development/images', 'public');
            }
        }

        if ($request->hasFile('document')) {
            if ($institutionalDevelopment->document_path) {
                Storage::disk('public')->delete($institutionalDevelopment->document_path);
            }

            $file = $request->file('document');
            $data['document_path'] = $file->store('institutional-development/documents', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        $data['images'] = array_values($images);
        unset($data['document']);

        $institutionalDevelopment->update($data);

        return redirect()->route('admin.institutional-developments.index')->with('success', 'Item updated.');
    }

    public function destroy(InstitutionalDevelopment $institutionalDevelopment): RedirectResponse
    {
        if ($institutionalDevelopment->document_path) {
            Storage::disk('public')->delete($institutionalDevelopment->document_path);
        }

        foreach ($institutionalDevelopment->images ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }

        $institutionalDevelopment->delete();

        return redirect()->route('admin.institutional-developments.index')->with('success', 'Item removed.');
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
