<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeyLeader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KeyLeaderController extends Controller
{
    public function index(): View
    {
        $items = KeyLeader::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.key-leaders.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.key-leaders.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:8192',
            'role_en' => 'required|string|max:255',
            'role_si' => 'nullable|string|max:255',
            'role_ta' => 'nullable|string|max:255',
            'org_en' => 'required|string|max:2000',
            'org_si' => 'nullable|string|max:2000',
            'org_ta' => 'nullable|string|max:2000',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['image'] = $this->storeImage($request);

        KeyLeader::create($data);

        return redirect()->route('admin.key-leaders.index')->with('success', 'Key leader added.');
    }

    public function edit(KeyLeader $key_leader): View
    {
        return view('admin.key-leaders.edit', ['keyLeader' => $key_leader]);
    }

    public function update(Request $request, KeyLeader $key_leader): RedirectResponse
    {
        $data = $request->validate([
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'role_en' => 'required|string|max:255',
            'role_si' => 'nullable|string|max:255',
            'role_ta' => 'nullable|string|max:255',
            'org_en' => 'required|string|max:2000',
            'org_si' => 'nullable|string|max:2000',
            'org_ta' => 'nullable|string|max:2000',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? $key_leader->sort_order;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($key_leader->image) {
                Storage::disk('public')->delete($key_leader->image);
            }
            $data['image'] = $this->storeImage($request);
        } else {
            unset($data['image']);
        }

        $key_leader->update($data);

        return redirect()->route('admin.key-leaders.index')->with('success', 'Key leader updated.');
    }

    public function destroy(KeyLeader $key_leader): RedirectResponse
    {
        if ($key_leader->image) {
            Storage::disk('public')->delete($key_leader->image);
        }
        $key_leader->delete();

        return redirect()->route('admin.key-leaders.index')->with('success', 'Key leader removed.');
    }

    private function storeImage(Request $request): string
    {
        return $request->file('image')->store('key-leaders', 'public');
    }
}
