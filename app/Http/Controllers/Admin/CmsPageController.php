<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CmsPageController extends Controller
{
    public function index(): View
    {
        $pagesQuery = Page::query();

        if ($this->hasNavFields()) {
            $pagesQuery
                ->orderByDesc('show_in_nav')
                ->orderBy('nav_order');
        }

        $pages = $pagesQuery->orderBy('title')->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePage($request);
        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created.');
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validatePage($request, $page);
        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }

    private function validatePage(Request $request, ?Page $existing = null): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('pages', 'slug')->ignore($existing?->id),
            ],
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ];

        if ($this->hasNavFields()) {
            $rules['show_in_nav'] = 'nullable|boolean';
            $rules['nav_order'] = 'nullable|integer|min:0|max:9999';
        }

        $data = $request->validate($rules);

        if (empty($data['slug'])) {
            $data['slug'] = null;
        }

        if ($this->hasNavFields()) {
            $data['show_in_nav'] = $request->boolean('show_in_nav');
            $data['nav_order'] = (int) ($data['nav_order'] ?? 0);
        }

        return $data;
    }

    private function hasNavFields(): bool
    {
        return Schema::hasColumn('pages', 'show_in_nav')
            && Schema::hasColumn('pages', 'nav_order');
    }
}
