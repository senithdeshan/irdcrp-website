<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OtherAnnouncement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OtherAnnouncementController extends Controller
{
    public function index(): View
    {
        $items = OtherAnnouncement::query()
            ->orderBy('sort_order')
            ->orderByDesc('published_date')
            ->orderByDesc('id')
            ->get();

        return view('admin.other-announcements.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.other-announcements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['document_path'] = null;
        $data['document_original_name'] = null;
        $data['document_mime'] = null;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $data['document_path'] = $file->store('other-announcements', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        OtherAnnouncement::create($data);

        return redirect()->route('admin.other-announcements.index')->with('success', 'Other announcement created.');
    }

    public function edit(OtherAnnouncement $otherAnnouncement): View
    {
        return view('admin.other-announcements.edit', compact('otherAnnouncement'));
    }

    public function update(Request $request, OtherAnnouncement $otherAnnouncement): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('document')) {
            if ($otherAnnouncement->document_path) {
                Storage::disk('public')->delete($otherAnnouncement->document_path);
            }

            $file = $request->file('document');
            $data['document_path'] = $file->store('other-announcements', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
            $data['document_mime'] = $file->getClientMimeType();
        }

        $otherAnnouncement->update($data);

        return redirect()->route('admin.other-announcements.index')->with('success', 'Other announcement updated.');
    }

    public function destroy(OtherAnnouncement $otherAnnouncement): RedirectResponse
    {
        if ($otherAnnouncement->document_path) {
            Storage::disk('public')->delete($otherAnnouncement->document_path);
        }

        $otherAnnouncement->delete();

        return redirect()->route('admin.other-announcements.index')->with('success', 'Other announcement removed.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'document' => ['nullable', 'file', 'max:51200', 'mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,zip'],
            'published_date' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
