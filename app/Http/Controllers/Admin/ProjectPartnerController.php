<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectPartner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectPartnerController extends Controller
{
    public function index(): View
    {
        $items = ProjectPartner::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.project-partners.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.project-partners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['logo'] = $request->file('logo')->store('project-partners', 'public');

        ProjectPartner::create($data);

        return redirect()
            ->route('admin.project-partners.index')
            ->with('success', 'Project partner added.');
    }

    public function edit(ProjectPartner $projectPartner): View
    {
        return view('admin.project-partners.edit', compact('projectPartner'));
    }

    public function update(Request $request, ProjectPartner $projectPartner): RedirectResponse
    {
        $data = $this->validated($request, $projectPartner);

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($projectPartner->logo);
            $data['logo'] = $request->file('logo')->store('project-partners', 'public');
        } else {
            unset($data['logo']);
        }

        $projectPartner->update($data);

        return redirect()
            ->route('admin.project-partners.index')
            ->with('success', 'Project partner updated.');
    }

    public function destroy(ProjectPartner $projectPartner): RedirectResponse
    {
        Storage::disk('public')->delete($projectPartner->logo);
        $projectPartner->delete();

        return redirect()
            ->route('admin.project-partners.index')
            ->with('success', 'Project partner removed.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?ProjectPartner $projectPartner = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['required', 'boolean'],
            'logo' => [
                $projectPartner ? 'nullable' : 'required',
                'file',
                'mimes:jpg,jpeg,png,webp,svg',
                'max:4096',
            ],
        ]);

        $data['website_url'] = filled($data['website_url'] ?? null) ? trim($data['website_url']) : null;

        return $data;
    }
}
