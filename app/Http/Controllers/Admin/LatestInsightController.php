<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LatestInsight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LatestInsightController extends Controller
{
    public function index(): View
    {
        $items = LatestInsight::query()
            ->latest('insight_date')
            ->latest()
            ->get();

        return view('admin.latest-insights.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.latest-insights.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:120',
            'summary' => 'required|string|max:2000',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link_url' => ['nullable', 'string', 'max:500', $this->linkUrlRule()],
            'insight_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $data['link_url'] = filled($data['link_url'] ?? null) ? trim($data['link_url']) : null;

        $data['image'] = $request->file('image')->store('latest-insights', 'public');

        LatestInsight::create($data);

        return redirect()->route('admin.latest-insights.index')->with('success', 'Latest insight created.');
    }

    public function edit(LatestInsight $latestInsight): View
    {
        return view('admin.latest-insights.edit', compact('latestInsight'));
    }

    public function update(Request $request, LatestInsight $latestInsight): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:120',
            'summary' => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link_url' => ['nullable', 'string', 'max:500', $this->linkUrlRule()],
            'insight_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $data['link_url'] = filled($data['link_url'] ?? null) ? trim($data['link_url']) : null;

        if ($request->hasFile('image')) {
            if ($latestInsight->image) {
                Storage::disk('public')->delete($latestInsight->image);
            }

            $data['image'] = $request->file('image')->store('latest-insights', 'public');
        } else {
            unset($data['image']);
        }

        $latestInsight->update($data);

        return redirect()->route('admin.latest-insights.index')->with('success', 'Latest insight updated.');
    }

    public function destroy(LatestInsight $latestInsight): RedirectResponse
    {
        if ($latestInsight->image) {
            Storage::disk('public')->delete($latestInsight->image);
        }

        $latestInsight->delete();

        return redirect()->route('admin.latest-insights.index')->with('success', 'Latest insight removed.');
    }

    private function linkUrlRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail): void {
            if (! filled($value)) {
                return;
            }

            $url = trim((string) $value);

            if (str_starts_with($url, '/') || str_starts_with($url, '#')) {
                return;
            }

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return;
            }

            $fail('Enter a site path (e.g. /news or /about#mission) or a full URL (https://...).');
        };
    }
}
