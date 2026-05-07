<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectComponent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectComponentController extends Controller
{
    public function index(): View
    {
        $items = ProjectComponent::query()
            ->orderBy('sort_order')
            ->orderBy('component_number')
            ->get();

        return view('admin.project-components.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.project-components.create');
    }

    public function store(Request $request): RedirectResponse
    {
        ProjectComponent::create($this->validateComponent($request));

        return redirect()->route('admin.project-components.index')->with('success', 'Project component created.');
    }

    public function edit(ProjectComponent $projectComponent): View
    {
        return view('admin.project-components.edit', compact('projectComponent'));
    }

    public function update(Request $request, ProjectComponent $projectComponent): RedirectResponse
    {
        $projectComponent->update($this->validateComponent($request));

        return redirect()->route('admin.project-components.index')->with('success', 'Project component updated.');
    }

    public function destroy(ProjectComponent $projectComponent): RedirectResponse
    {
        $projectComponent->delete();

        return redirect()->route('admin.project-components.index')->with('success', 'Project component deleted.');
    }

    private function validateComponent(Request $request): array
    {
        return $request->validate([
            'component_number' => 'required|integer|min:1|max:99',
            'title' => 'required|string|max:255',
            'budget' => 'nullable|string|max:255',
            'beneficiaries' => 'nullable|string|max:255',
            'description' => 'required|string|max:5000',
            'sort_order' => 'required|integer|min:0|max:999',
            'status' => 'required|in:draft,published',
        ]);
    }
}
