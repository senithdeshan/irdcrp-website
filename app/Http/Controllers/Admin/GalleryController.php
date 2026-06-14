<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Admin CRUD for gallery media shown on the public gallery sections.
 */
class GalleryController extends Controller
{
    public function index(): View
    {
        $category = request('category', '');

        $items = Gallery::query()
            ->when(array_key_exists($category, Gallery::CATEGORIES), function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->orderedForDisplay()
            ->get();

        $pinnedCount = $items->where('is_pinned', true)->count();

        return view('admin.gallery.index', compact('items', 'category', 'pinnedCount'));
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'categories' => Gallery::CATEGORIES,
            'mediaTypes' => Gallery::MEDIA_TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedGallery($request);
        $data = $this->storeMedia($request, $data);
        $data['is_pinned'] = false;

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', [
            'gallery' => $gallery,
            'categories' => Gallery::CATEGORIES,
            'mediaTypes' => Gallery::MEDIA_TYPES,
        ]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $data = $this->validatedGallery($request, $gallery);
        $data = $this->storeMedia($request, $data, $gallery);
        unset($data['is_pinned']);

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->mediaPath()) {
            Storage::disk('public')->delete($gallery->mediaPath());
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item removed.');
    }

    public function togglePin(Request $request, Gallery $gallery): RedirectResponse
    {
        $category = $request->input('category', '');

        if ($gallery->is_pinned) {
            $gallery->update(['is_pinned' => false]);

            $message = 'Removed from pinned items.';
        } else {
            $replaced = $this->applyPinLimit($gallery->category, $gallery->id);
            $gallery->update(['is_pinned' => true]);

            $message = $replaced
                ? 'Pinned to top. The oldest pinned item in this category was replaced.'
                : 'Pinned to top of this category.';
        }

        return redirect()
            ->route('admin.gallery.index', array_filter(['category' => $category]))
            ->with('success', $message);
    }

    private function validatedGallery(Request $request, ?Gallery $gallery = null): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => ['required', Rule::in(array_keys(Gallery::CATEGORIES))],
            'media_type' => ['required', Rule::in(array_keys(Gallery::MEDIA_TYPES))],
            'description' => 'nullable|string|max:2000',
            'item_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'external_url' => 'nullable|url|max:2048',
            'media_file' => [$gallery ? 'nullable' : 'required_without:external_url', 'file', $this->fileRuleFor($request)],
        ]);

        if (empty($data['external_url']) && ! $request->hasFile('media_file') && ! $gallery?->mediaPath()) {
            $request->validate([
                'media_file' => 'required',
            ]);
        }

        if (! empty($data['external_url']) && ! $request->hasFile('media_file')) {
            $data['media_type'] = $data['media_type'] === 'image' ? 'link' : $data['media_type'];
        }

        unset($data['media_file']);

        return $data;
    }

    private function applyPinLimit(string $category, ?int $ignoreId = null): bool
    {
        $pinned = Gallery::query()
            ->where('category', $category)
            ->where('is_pinned', true)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->orderBy('item_date')
            ->orderBy('id')
            ->get();

        $overflow = $pinned->count() - Gallery::MAX_PINNED_PER_CATEGORY + 1;

        if ($overflow <= 0) {
            return false;
        }

        $pinned
            ->take($overflow)
            ->each(fn (Gallery $item) => $item->update(['is_pinned' => false]));

        return true;
    }

    private function fileRuleFor(Request $request): string
    {
        return match ($request->input('media_type')) {
            'image' => 'mimes:jpg,jpeg,png,webp|max:8192',
            'audio' => 'mimes:mp3,wav,m4a,ogg,aac|max:51200',
            'video' => 'mimes:mp4,mov,webm,avi|max:204800',
            'document' => 'mimes:pdf,ppt,pptx,pps,ppsx|max:51200',
            default => 'max:51200',
        };
    }

    private function storeMedia(Request $request, array $data, ?Gallery $gallery = null): array
    {
        if ($request->hasFile('media_file')) {
            if ($gallery?->mediaPath()) {
                Storage::disk('public')->delete($gallery->mediaPath());
            }

            $path = $request->file('media_file')->store('gallery/'.$data['category'], 'public');
            $data['file_path'] = $path;
            $data['image'] = $path;
            $data['external_url'] = null;
        } elseif ($gallery) {
            $data['file_path'] = $gallery->file_path;
            $data['image'] = $gallery->image;
        }

        if (! empty($data['external_url'])) {
            if ($gallery?->mediaPath()) {
                Storage::disk('public')->delete($gallery->mediaPath());
            }

            $data['file_path'] = null;
            $data['image'] = $data['external_url'];
        }

        return $data;
    }
}
