<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SafeguardResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SafeguardResourceController extends Controller
{
    public function index(): View
    {
        $items = SafeguardResource::query()
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.safeguards.index', [
            'items' => $items,
            'categories' => SafeguardResource::CATEGORIES,
        ]);
    }

    public function create(): View
    {
        return view('admin.safeguards.create', [
            'categories' => SafeguardResource::CATEGORIES,
        ]);
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
            $data['document_path'] = $file->store('safeguards/documents', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        if ($request->hasFile('images')) {
            $data['images'] = collect($request->file('images'))
                ->map(fn ($image): string => $image->store('safeguards/images', 'public'))
                ->values()
                ->all();
        }

        unset($data['document']);

        SafeguardResource::create($data);

        return redirect()->route('admin.safeguards.index')->with('success', 'Safeguard item created.');
    }

    public function edit(SafeguardResource $safeguard): View
    {
        return view('admin.safeguards.edit', [
            'categories' => SafeguardResource::CATEGORIES,
            'safeguard' => $safeguard,
        ]);
    }

    public function update(Request $request, SafeguardResource $safeguard): RedirectResponse
    {
        $data = $this->validatedData($request);
        $images = $safeguard->images ?? [];
        $removeImages = array_filter((array) $request->input('remove_images', []));

        if ($removeImages !== []) {
            foreach ($removeImages as $path) {
                Storage::disk('public')->delete($path);
            }
            $images = array_values(array_diff($images, $removeImages));
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('safeguards/images', 'public');
            }
        }

        if ($request->hasFile('document')) {
            if ($safeguard->document_path) {
                Storage::disk('public')->delete($safeguard->document_path);
            }

            $file = $request->file('document');
            $data['document_path'] = $file->store('safeguards/documents', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        $data['images'] = array_values($images);
        unset($data['document']);

        $safeguard->update($data);

        return redirect()->route('admin.safeguards.index')->with('success', 'Safeguard item updated.');
    }

    public function destroy(SafeguardResource $safeguard): RedirectResponse
    {
        if ($safeguard->document_path) {
            Storage::disk('public')->delete($safeguard->document_path);
        }

        foreach ($safeguard->images ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }

        $safeguard->delete();

        return redirect()->route('admin.safeguards.index')->with('success', 'Safeguard item removed.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'category' => ['required', Rule::in(array_keys(SafeguardResource::CATEGORIES))],
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
