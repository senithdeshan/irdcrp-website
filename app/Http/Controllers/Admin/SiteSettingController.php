<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        return view('admin.site-settings.edit', [
            'socialLinks' => $settings->socialLinks(),
            'socialKeys' => SiteSettings::SOCIAL_KEYS,
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $rules = [];

        foreach (SiteSettings::SOCIAL_KEYS as $key) {
            $rules["social.$key"] = ['nullable', 'url', 'max:500'];
        }

        $validated = $request->validate($rules);

        $settings->putSocialLinks($validated['social'] ?? []);

        return redirect()
            ->route('admin.site-settings.edit')
            ->with('success', 'Social channel links updated.');
    }
}
