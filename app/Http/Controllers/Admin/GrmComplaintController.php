<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrmComplaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class GrmComplaintController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', '');

        $items = GrmComplaint::query()
            ->when(in_array($status, ['new', 'in_progress', 'solved'], true), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.grm-complaints.index', compact('items', 'status'));
    }

    public function edit(GrmComplaint $grmComplaint): View
    {
        return view('admin.grm-complaints.edit', compact('grmComplaint'));
    }

    public function update(Request $request, GrmComplaint $grmComplaint): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:new,in_progress,solved',
            'admin_reply' => 'nullable|string|max:5000',
            'resolution_reason' => 'nullable|string|max:5000',
        ]);

        if ($data['status'] === 'solved' && empty($grmComplaint->resolved_at)) {
            $data['resolved_at'] = Carbon::now();
        }

        if ($data['status'] !== 'solved') {
            $data['resolved_at'] = null;
        }

        $grmComplaint->update($data);

        return redirect()
            ->route('admin.grm-complaints.index')
            ->with('success', 'GRM complaint updated successfully.');
    }
}

