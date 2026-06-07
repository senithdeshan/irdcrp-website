<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomePopupController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        return view('admin.home-popup.edit', [
            'popup' => $settings->homePopupForAdmin(),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $current = $settings->homePopupForAdmin();

        $validated = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'link_url' => ['nullable', 'url', 'max:500'],
            'alt' => ['nullable', 'string', 'max:255'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $popup = [
            'enabled' => $request->boolean('enabled'),
            'image' => $current['image'] ?? null,
            'link_url' => $validated['link_url'] ?? null,
            'alt' => filled($validated['alt'] ?? null) ? $validated['alt'] : 'Important announcement',
        ];

        if ($request->boolean('remove_image')) {
            $settings->deleteStoredHomePopupImage($popup['image']);
            $popup['image'] = null;
            $popup['enabled'] = false;
        } elseif ($request->hasFile('image')) {
            $settings->deleteStoredHomePopupImage($popup['image']);
            $path = $request->file('image')->store('home-popup', 'public');
            $popup['image'] = 'storage/'.$path;
        }

        if ($popup['enabled'] && ! filled($popup['image'])) {
            return back()
                ->withInput()
                ->withErrors(['image' => 'Upload an image before activating the home popup.']);
        }

        $settings->putHomePopup($popup);

        return redirect()
            ->route('admin.home-popup.edit')
            ->with('success', 'Home popup settings saved.');
    }
}
