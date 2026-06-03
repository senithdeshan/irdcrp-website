<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        return view('admin.about-page.edit', [
            'about' => $settings->aboutPageForAdmin(),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:draft,published'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:255'],
            'mission_title' => ['required', 'string', 'max:255'],
            'mission_text' => ['required', 'string', 'max:5000'],
            'objectives_title' => ['required', 'string', 'max:255'],
            'objectives_text' => ['required', 'string', 'max:5000'],
            'grievance_heading' => ['required', 'string', 'max:255'],
            'grievance_lead' => ['required', 'string', 'max:5000'],
            'grievance_cards' => ['required', 'array', 'size:3'],
            'grievance_cards.*.title' => ['required', 'string', 'max:255'],
            'grievance_cards.*.text' => ['required', 'string', 'max:1000'],
            'why_heading' => ['required', 'string', 'max:255'],
            'why_cards' => ['required', 'array', 'size:3'],
            'why_cards.*.title' => ['required', 'string', 'max:255'],
            'why_cards.*.text' => ['required', 'string', 'max:1000'],
        ]);

        $settings->putAboutPage($data);

        return redirect()
            ->route('admin.about-page.edit')
            ->with('success', 'About Us page updated.');
    }
}
