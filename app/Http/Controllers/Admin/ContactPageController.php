<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        $contact = $settings->contactPageForAdmin();

        return view('admin.contact-page.edit', [
            'contact' => $contact,
            'locationImageUrl' => $settings->contactLocationImageUrl($contact['location']['image'] ?? null),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $validated = $request->validate([
            'emails_raw' => ['required', 'string', 'max:2000'],
            'phone' => ['required', 'string', 'max:100'],
            'fax' => ['nullable', 'string', 'max:100'],
            'website_url' => ['required', 'url', 'max:500'],
            'website_label' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'form_title' => ['required', 'string', 'max:255'],
            'form_subtitle' => ['required', 'string', 'max:500'],
            'location_title' => ['required', 'string', 'max:255'],
            'location_unit' => ['required', 'string', 'max:255'],
            'location_project' => ['required', 'string', 'max:500'],
            'location_place_name' => ['required', 'string', 'max:500'],
            'location_latitude' => ['required', 'numeric', 'between:-90,90'],
            'location_longitude' => ['required', 'numeric', 'between:-180,180'],
            'location_map_zoom' => ['required', 'integer', 'between:1,21'],
            'location_maps_url' => ['nullable', 'url', 'max:500'],
            'location_image_caption' => ['nullable', 'string', 'max:500'],
            'location_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        $emails = collect(preg_split('/\R/', $validated['emails_raw']))
            ->map(fn (string $email): string => trim($email))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($emails === []) {
            return back()
                ->withErrors(['emails_raw' => 'Add at least one email address.'])
                ->withInput();
        }

        foreach ($emails as $email) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return back()
                    ->withErrors(['emails_raw' => "Invalid email address: {$email}"])
                    ->withInput();
            }
        }

        $current = $settings->contactPageForAdmin();
        $location = is_array($current['location'] ?? null) ? $current['location'] : [];

        if ($request->hasFile('location_image')) {
            $settings->deleteStoredContactLocationImage($location['image'] ?? null);
            $location['image'] = $request->file('location_image')->store('contact', 'public');
        }

        $location['title'] = $validated['location_title'];
        $location['unit'] = $validated['location_unit'];
        $location['project'] = $validated['location_project'];
        $location['place_name'] = $validated['location_place_name'];
        $location['latitude'] = (float) $validated['location_latitude'];
        $location['longitude'] = (float) $validated['location_longitude'];
        $location['map_zoom'] = (int) $validated['location_map_zoom'];
        $location['maps_url'] = $validated['location_maps_url'] ?? null;
        $location['image_caption'] = $validated['location_image_caption'] ?? null;

        $settings->putContactPage([
            'emails' => $emails,
            'phone' => $validated['phone'],
            'fax' => $validated['fax'] ?? '',
            'website_url' => $validated['website_url'],
            'website_label' => $validated['website_label'],
            'address' => $validated['address'],
            'form_title' => $validated['form_title'],
            'form_subtitle' => $validated['form_subtitle'],
            'location' => $location,
        ]);

        return redirect()
            ->route('admin.contact-page.edit')
            ->with('success', 'Contact page updated.');
    }
}
