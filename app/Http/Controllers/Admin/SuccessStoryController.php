<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SuccessStoryController extends Controller
{
    public function index(): View
    {
        $items = SuccessStory::query()->latest()->get();

        return view('admin.success-stories.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.success-stories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'story' => 'required|string|max:2000',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
        ]);

        $data['photo'] = $request->file('photo')->store('success-stories', 'public');
        SuccessStory::create($data);

        return redirect()->route('admin.success-stories.index')->with('success', 'Success story created.');
    }

    public function edit(SuccessStory $successStory): View
    {
        return view('admin.success-stories.edit', compact('successStory'));
    }

    public function update(Request $request, SuccessStory $successStory): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'story' => 'required|string|max:2000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('photo')) {
            if ($successStory->photo) {
                Storage::disk('public')->delete($successStory->photo);
            }
            $data['photo'] = $request->file('photo')->store('success-stories', 'public');
        } else {
            unset($data['photo']);
        }

        $successStory->update($data);

        return redirect()->route('admin.success-stories.index')->with('success', 'Success story updated.');
    }

    public function destroy(SuccessStory $successStory): RedirectResponse
    {
        if ($successStory->photo) {
            Storage::disk('public')->delete($successStory->photo);
        }
        $successStory->delete();

        return redirect()->route('admin.success-stories.index')->with('success', 'Success story removed.');
    }
}
