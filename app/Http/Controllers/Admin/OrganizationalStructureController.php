<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizationalStructureController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        return view('admin.organizational-structure.edit', [
            'structure' => $settings->organizationalStructure(),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $validated = $request->validate([
            'section_title' => ['required', 'string', 'max:160'],
            'section_subtitle' => ['nullable', 'string', 'max:500'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'structure_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'remove_structure_image' => ['nullable', 'boolean'],
            'staff_fallback_image_alt' => ['nullable', 'string', 'max:255'],
            'staff_fallback_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'remove_staff_fallback_image' => ['nullable', 'boolean'],
        ]);

        $current = $settings->organizationalStructure();
        $payload = [
            'section_title' => $validated['section_title'],
            'section_subtitle' => $validated['section_subtitle'] ?? null,
            'image_alt' => $validated['image_alt'] ?? 'IRDCRP organizational structure',
            'image' => $current['image'] ?? null,
            'staff_fallback_image' => $current['staff_fallback_image'] ?? null,
            'staff_fallback_image_alt' => $validated['staff_fallback_image_alt']
                ?? ($current['staff_fallback_image_alt'] ?? 'IRDCRP project staff'),
        ];

        if ($request->boolean('remove_structure_image')) {
            $settings->deleteStoredOrganizationalStructureImage($current['image'] ?? null);
            $payload['image'] = null;
        }

        if ($request->hasFile('structure_image')) {
            $settings->deleteStoredOrganizationalStructureImage($current['image'] ?? null);
            $path = $request->file('structure_image')->store('organizational-structure', 'public');
            $payload['image'] = 'storage/'.$path;
        }

        if ($request->boolean('remove_staff_fallback_image')) {
            $settings->deleteStoredOrganizationalStructureImage($current['staff_fallback_image'] ?? null);
            $payload['staff_fallback_image'] = null;
        }

        if ($request->hasFile('staff_fallback_image')) {
            $settings->deleteStoredOrganizationalStructureImage($current['staff_fallback_image'] ?? null);
            $path = $request->file('staff_fallback_image')->store('organizational-structure', 'public');
            $payload['staff_fallback_image'] = 'storage/'.$path;
        }

        $settings->putOrganizationalStructure($payload);

        return redirect()
            ->route('admin.organizational-structure.edit')
            ->with('success', 'Organizational Structure page updated.');
    }
}
