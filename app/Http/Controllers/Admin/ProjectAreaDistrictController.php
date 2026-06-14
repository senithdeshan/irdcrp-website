<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectAreaDistrict;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ProjectAreaDistrictController extends Controller
{
    public function create(): View
    {
        return view('admin.project-area-districts.create', [
            'districtTableReady' => Schema::hasTable('project_area_districts'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (! Schema::hasTable('project_area_districts')) {
            return redirect()
                ->route('admin.project-areas.edit')
                ->withErrors(['district' => 'District table is not ready. Run: php artisan migrate']);
        }

        ProjectAreaDistrict::create($this->validated($request));

        return redirect()
            ->route('admin.project-areas.edit')
            ->with('success', 'District area added.');
    }

    public function edit(ProjectAreaDistrict $projectAreaDistrict): View
    {
        return view('admin.project-area-districts.edit', [
            'district' => $projectAreaDistrict,
            'districtTableReady' => Schema::hasTable('project_area_districts'),
        ]);
    }

    public function update(Request $request, ProjectAreaDistrict $projectAreaDistrict): RedirectResponse
    {
        if (! Schema::hasTable('project_area_districts')) {
            return redirect()
                ->route('admin.project-areas.edit')
                ->withErrors(['district' => 'District table is not ready. Run: php artisan migrate']);
        }

        $projectAreaDistrict->update($this->validated($request));

        return redirect()
            ->route('admin.project-areas.edit')
            ->with('success', 'District area updated.');
    }

    public function destroy(ProjectAreaDistrict $projectAreaDistrict): RedirectResponse
    {
        $projectAreaDistrict->delete();

        return redirect()
            ->route('admin.project-areas.edit')
            ->with('success', 'District area removed.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'district' => ['required', 'string', 'max:255'],
            'ds_divisions' => ['nullable', 'string', 'max:2000'],
            'focus' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
