<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeImageController extends Controller
{
    public function index(): View
    {
        $items = HomeImage::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.home-images.index', compact('items'));
    }

    public function edit(HomeImage $homeImage): View
    {
        return view('admin.home-images.edit', compact('homeImage'));
    }

    public function update(Request $request, HomeImage $homeImage): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'caption' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:7'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($homeImage->image_path) {
                Storage::disk('public')->delete($homeImage->image_path);
            }

            $data['image_path'] = $request->file('image')->store('home-images', 'public');
        }

        unset($data['image']);
        $homeImage->update($data);

        return redirect()->route('admin.home-images.index')->with('success', 'Home image updated.');
    }
}
