<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrmComplaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class GrmComplaintController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', '');
        $search = trim((string) $request->query('q', ''));

        $items = GrmComplaint::query()
            ->when(in_array($status, ['new', 'in_progress', 'solved'], true), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%")
                        ->orWhere('admin_reply', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = Schema::hasTable('grm_complaints')
            ? GrmComplaint::summaryStats()
            : ['total' => 0, 'solved' => 0, 'in_progress' => 0, 'unsolved' => 0];

        return view('admin.grm-complaints.index', compact('items', 'status', 'search', 'stats'));
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

    public function destroy(GrmComplaint $grmComplaint): RedirectResponse
    {
        $grmComplaint->delete();

        return redirect()
            ->route('admin.grm-complaints.index')
            ->with('success', 'GRM complaint deleted successfully.');
    }
}
