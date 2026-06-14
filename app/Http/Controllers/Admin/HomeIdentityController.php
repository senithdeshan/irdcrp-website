<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeIdentityController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        return view('admin.home-identity.edit', [
            'identity' => $settings->homeIdentityForAdmin(),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $validated = $request->validate([
            'eyebrow' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:255'],
            'paragraphs' => ['required', 'string', 'max:8000'],
            'badges' => ['nullable', 'string', 'max:1000'],
            'names.si' => ['nullable', 'string', 'max:500'],
            'names.ta' => ['nullable', 'string', 'max:500'],
            'names.en' => ['required', 'string', 'max:500'],
        ]);

        $settings->putHomeIdentity([
            'eyebrow' => $validated['eyebrow'],
            'title' => $validated['title'],
            'paragraphs' => $this->lines($validated['paragraphs']),
            'badges' => $this->lines($validated['badges'] ?? ''),
            'names' => $validated['names'] ?? [],
        ]);

        return redirect()
            ->route('admin.home-identity.edit')
            ->with('success', 'Project identity section updated.');
    }

    /**
     * @return list<string>
     */
    private function lines(string $value): array
    {
        return collect(preg_split('/\R+/', $value) ?: [])
            ->map(fn (string $line): string => trim($line))
            ->filter(fn (string $line): bool => filled($line))
            ->values()
            ->all();
    }
}
