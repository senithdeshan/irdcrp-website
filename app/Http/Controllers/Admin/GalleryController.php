<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Admin CRUD for photo items shown on the public site at /gallery/photos.
 */
class GalleryController extends Controller
{
    public function index(): View
    {
        $items = Gallery::query()
            ->orderByDesc('item_date')
            ->orderByDesc('id')
            ->get();

        return view('admin.gallery.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'item_date' => 'nullable|date',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data['image'] = $request->file('image')->store('gallery', 'public');
        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image added to gallery.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'item_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = $request->file('image')->store('gallery', 'public');
        } else {
            unset($data['image']);
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item removed.');
    }
}
