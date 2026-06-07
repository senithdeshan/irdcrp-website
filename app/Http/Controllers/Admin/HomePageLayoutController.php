<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\HomePageBlocks;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomePageLayoutController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        return view('admin.home-layout.edit', [
            'blocks' => $settings->homeBlocksForAdmin(),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $validated = $request->validate([
            'blocks' => ['required', 'array', 'min:1'],
            'blocks.*.id' => ['required', 'string'],
            'blocks.*.enabled' => ['nullable', 'boolean'],
        ]);

        $allowed = collect(HomePageBlocks::definitions())->keyBy('id');
        $ordered = [];

        foreach ($validated['blocks'] as $index => $row) {
            $id = (string) $row['id'];
            if (! $allowed->has($id)) {
                continue;
            }

            $ordered[] = [
                'id' => $id,
                'enabled' => (bool) ($row['enabled'] ?? false),
                'sort_order' => ($index + 1) * 10,
            ];
        }

        $settings->putHomeBlocks($ordered);

        return redirect()
            ->route('admin.home-layout.edit')
            ->with('success', 'Home page section order saved.');
    }
}
