<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    public function index(): View
    {
        $items = Programme::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('admin.programmes.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.programmes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProgramme($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programmes', 'public');
        }

        Programme::create($data);

        return redirect()->route('admin.programmes.index')->with('success', 'Programme created.');
    }

    public function edit(Programme $programme): View
    {
        return view('admin.programmes.edit', compact('programme'));
    }

    public function update(Request $request, Programme $programme): RedirectResponse
    {
        $data = $this->validateProgramme($request, $programme);

        if ($request->hasFile('image')) {
            if ($programme->image && ! str_starts_with($programme->image, 'images/')) {
                Storage::disk('public')->delete($programme->image);
            }
            $data['image'] = $request->file('image')->store('programmes', 'public');
        }

        $programme->update($data);

        return redirect()->route('admin.programmes.index')->with('success', 'Programme updated.');
    }

    public function destroy(Programme $programme): RedirectResponse
    {
        if ($programme->image && ! str_starts_with($programme->image, 'images/')) {
            Storage::disk('public')->delete($programme->image);
        }

        $programme->delete();

        return redirect()->route('admin.programmes.index')->with('success', 'Programme deleted.');
    }

    private function validateProgramme(Request $request, ?Programme $programme = null): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('programmes', 'slug')->ignore($programme?->id),
            ],
            'summary' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:10000',
            'sort_order' => 'required|integer|min:0|max:999',
            'status' => 'required|in:draft,published',
            'image' => ($programme ? 'nullable' : 'required').'|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }
}
