<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ProjectAreaController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        return view('admin.project-areas.edit', [
            'projectAreas' => $settings->projectAreas(),
            'districts' => $settings->projectAreaDistrictsForAdmin(),
            'districtTableReady' => Schema::hasTable('project_area_districts'),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $validated = $request->validate([
            'hero_title' => ['required', 'string', 'max:160'],
            'hero_subtitle' => ['nullable', 'string', 'max:255'],
            'section_title' => ['required', 'string', 'max:160'],
            'section_subtitle' => ['nullable', 'string', 'max:500'],
            'summary_title' => ['required', 'string', 'max:160'],
            'summary_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'summary' => ['required', 'array'],
            'summary.*.label' => ['nullable', 'string', 'max:120'],
            'summary.*.value' => ['nullable', 'string', 'max:255'],
            'table_title' => ['required', 'string', 'max:160'],
            'table_headings.district' => ['required', 'string', 'max:120'],
            'table_headings.ds_divisions' => ['required', 'string', 'max:120'],
            'table_headings.focus' => ['required', 'string', 'max:120'],
        ]);

        $current = $settings->projectAreas();

        $projectAreas = [
            'hero_title' => $validated['hero_title'],
            'hero_subtitle' => $validated['hero_subtitle'] ?? null,
            'section_title' => $validated['section_title'],
            'section_subtitle' => $validated['section_subtitle'] ?? null,
            'summary_title' => $validated['summary_title'],
            'summary_image' => $current['summary_image'] ?? null,
            'summary' => $this->filledSummaryRows($validated['summary']),
            'table_title' => $validated['table_title'],
            'table_headings' => $validated['table_headings'],
        ];

        if ($request->hasFile('summary_image')) {
            $settings->deleteStoredProjectAreaImage($current['summary_image'] ?? null);
            $path = $request->file('summary_image')->store('project-areas', 'public');
            $projectAreas['summary_image'] = 'storage/'.$path;
        }

        $settings->putProjectAreas($projectAreas);

        return redirect()
            ->route('admin.project-areas.edit')
            ->with('success', 'Project areas updated.');
    }

    private function filledSummaryRows(array $rows): array
    {
        return collect($rows)
            ->map(fn (array $row): array => [
                'label' => trim((string) ($row['label'] ?? '')),
                'value' => trim((string) ($row['value'] ?? '')),
            ])
            ->filter(fn (array $row): bool => filled($row['label']) || filled($row['value']))
            ->values()
            ->all();
    }

}
