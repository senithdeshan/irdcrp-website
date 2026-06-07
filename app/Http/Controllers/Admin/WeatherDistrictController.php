<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeatherDistrict;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WeatherDistrictController extends Controller
{
    public function index(SiteSettings $settings): View
    {
        $items = WeatherDistrict::query()
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get();

        return view('admin.weather-districts.index', [
            'items' => $items,
            'weatherSettings' => $settings->weatherSettings(),
            'defaultImageUrl' => $settings->weatherDefaultImageUrl(),
        ]);
    }

    public function updateSettings(Request $request, SiteSettings $settings): RedirectResponse
    {
        $request->validate([
            'default_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        $current = $settings->weatherSettings();
        $payload = $current;

        if ($request->hasFile('default_image')) {
            $settings->deleteStoredWeatherImage($current['default_image'] ?? null);
            $payload['default_image'] = $request->file('default_image')->store('weather', 'public');
        }

        $settings->putWeatherSettings($payload);

        return redirect()
            ->route('admin.weather-districts.index')
            ->with('success', 'Weather section image updated.');
    }

    public function create(): View
    {
        return view('admin.weather-districts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name_en']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('weather/districts', 'public');
        }

        WeatherDistrict::create($data);

        return redirect()
            ->route('admin.weather-districts.index')
            ->with('success', 'Weather district added.');
    }

    public function edit(WeatherDistrict $weatherDistrict): View
    {
        return view('admin.weather-districts.edit', compact('weatherDistrict'));
    }

    public function update(Request $request, WeatherDistrict $weatherDistrict): RedirectResponse
    {
        $data = $this->validated($request, $weatherDistrict);
        $data['slug'] = $this->uniqueSlug($data['name_en'], $weatherDistrict->id);

        if ($request->hasFile('image')) {
            $this->deleteDistrictImage($weatherDistrict->image);
            $data['image'] = $request->file('image')->store('weather/districts', 'public');
        } else {
            unset($data['image']);
        }

        $weatherDistrict->update($data);

        return redirect()
            ->route('admin.weather-districts.index')
            ->with('success', 'Weather district updated.');
    }

    public function destroy(WeatherDistrict $weatherDistrict): RedirectResponse
    {
        $this->deleteDistrictImage($weatherDistrict->image);
        $weatherDistrict->delete();

        return redirect()
            ->route('admin.weather-districts.index')
            ->with('success', 'Weather district removed.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?WeatherDistrict $weatherDistrict = null): array
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:255'],
            'name_si' => ['nullable', 'string', 'max:255'],
            'name_ta' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        $data['name_si'] = filled($data['name_si'] ?? null) ? $data['name_si'] : null;
        $data['name_ta'] = filled($data['name_ta'] ?? null) ? $data['name_ta'] : null;

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'district';
        $slug = $base;
        $counter = 2;

        while (
            WeatherDistrict::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function deleteDistrictImage(?string $path): void
    {
        if (! filled($path) || str_starts_with($path, 'images/')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
