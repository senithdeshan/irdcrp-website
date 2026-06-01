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
            'footerSettings' => $settings->footer(),
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

        $rules['footer.project_name'] = ['required', 'string', 'max:255'];
        $rules['footer.address'] = ['nullable', 'string', 'max:1000'];
        $rules['footer.email'] = ['nullable', 'email', 'max:255'];
        $rules['footer.phone'] = ['nullable', 'string', 'max:100'];
        $rules['footer_logo'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        $validated = $request->validate($rules);

        $footer = $validated['footer'] ?? [];
        $currentFooter = $settings->footer();

        if ($request->hasFile('footer_logo')) {
            $settings->deleteStoredFooterLogo($currentFooter['logo'] ?? null);
            $path = $request->file('footer_logo')->store('footer-logos', 'public');
            $footer['logo'] = 'storage/'.$path;
        } else {
            $footer['logo'] = $currentFooter['logo'] ?? config('irdcrp.logos.irdcrp');
        }

        $settings->putFooter($footer);
        $settings->putSocialLinks($validated['social'] ?? []);

        return redirect()
            ->route('admin.site-settings.edit')
            ->with('success', 'Footer details and social channel links updated.');
    }
}
