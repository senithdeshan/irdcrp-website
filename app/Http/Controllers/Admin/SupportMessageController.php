<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class SupportMessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', '');

        $items = SupportMessage::query()
            ->when(in_array($status, ['new', 'in_progress', 'resolved'], true), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.support-messages.index', compact('items', 'status'));
    }

    public function edit(SupportMessage $supportMessage): View
    {
        return view('admin.support-messages.edit', compact('supportMessage'));
    }

    public function update(Request $request, SupportMessage $supportMessage): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:new,in_progress,resolved',
            'admin_reply' => 'nullable|string|max:5000',
        ]);

        if ($data['status'] === 'resolved' && empty($supportMessage->resolved_at)) {
            $data['resolved_at'] = Carbon::now();
        }

        if ($data['status'] !== 'resolved') {
            $data['resolved_at'] = null;
        }

        $supportMessage->update($data);

        return redirect()
            ->route('admin.support-messages.index')
            ->with('success', 'Support message updated successfully.');
    }
}
