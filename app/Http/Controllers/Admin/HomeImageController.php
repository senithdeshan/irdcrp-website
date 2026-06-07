<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeImage;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeImageController extends Controller
{
    public function index(SiteSettings $settings): View
    {
        $items = HomeImage::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.home-images.index', [
            'items' => $items,
            'sliderSettings' => $settings->homeHeroSlider(),
        ]);
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
            'display_from' => ['nullable', 'date'],
            'display_until' => ['nullable', 'date', 'after_or_equal:display_from'],
        ]);

        $data['display_from'] = filled($data['display_from'] ?? null) ? $data['display_from'] : null;
        $data['display_until'] = filled($data['display_until'] ?? null) ? $data['display_until'] : null;

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

    public function updateSliderSettings(Request $request, SiteSettings $settings): RedirectResponse
    {
        $data = $request->validate([
            'slide_interval_seconds' => ['required', 'integer', 'min:3', 'max:60'],
        ]);

        $settings->putHomeHeroSlider($data);

        return redirect()
            ->route('admin.home-images.index')
            ->with('success', 'Hero slider timing updated.');
    }
}
