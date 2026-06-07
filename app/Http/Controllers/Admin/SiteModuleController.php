<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteModules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteModuleController extends Controller
{
    public function index(SiteModules $modules): View
    {
        return view('admin.site-modules.index', [
            'modules' => $modules->forAdmin(),
        ]);
    }

    public function update(Request $request, SiteModules $modules): RedirectResponse
    {
        $definitions = SiteModules::definitions();
        $states = [];

        foreach (array_keys($definitions) as $id) {
            $states[$id] = $request->boolean('modules.'.$id);
        }

        $modules->saveStates($states);

        return redirect()
            ->route('admin.site-modules.index')
            ->with('success', 'Site modules updated. Disabled modules are removed from the public site until you plug them back in.');
    }
}
