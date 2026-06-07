<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    public function index(): View
    {
        $items = Programme::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('admin.programmes.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.programmes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProgramme($request);
        $data['content_blocks'] = $this->buildContentBlocks($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programmes', 'public');
        }

        Programme::create($data);

        return redirect()->route('admin.programmes.index')->with('success', 'Programme created.');
    }

    public function edit(Programme $programme): View
    {
        return view('admin.programmes.edit', compact('programme'));
    }

    public function update(Request $request, Programme $programme): RedirectResponse
    {
        $data = $this->validateProgramme($request, $programme);
        $data['content_blocks'] = $this->buildContentBlocks($request, $programme);

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($programme->image);
            $data['image'] = $request->file('image')->store('programmes', 'public');
        }

        $programme->update($data);

        return redirect()->route('admin.programmes.index')->with('success', 'Programme updated.');
    }

    public function destroy(Programme $programme): RedirectResponse
    {
        $this->deleteStoredImage($programme->image);
        $this->deleteBlockImages($programme->content_blocks ?? []);

        $programme->delete();

        return redirect()->route('admin.programmes.index')->with('success', 'Programme deleted.');
    }

    private function validateProgramme(Request $request, ?Programme $programme = null): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('programmes', 'slug')->ignore($programme?->id),
            ],
            'summary' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:10000',
            'sort_order' => 'required|integer|min:0|max:999',
            'status' => 'required|in:draft,published',
            'image' => ($programme ? 'nullable' : 'required').'|image|mimes:jpg,jpeg,png,webp|max:8192',
            'blocks' => 'nullable|array|max:30',
            'blocks.*.type' => 'required|in:text,image,table',
            'blocks.*.body' => 'nullable|string|max:10000',
            'blocks.*.caption' => 'nullable|string|max:255',
            'blocks.*.title' => 'nullable|string|max:255',
            'blocks.*.headers_text' => 'nullable|string|max:1000',
            'blocks.*.rows_text' => 'nullable|string|max:10000',
            'blocks.*.existing_path' => 'nullable|string|max:255',
            'blocks.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['title']);
        }

        unset($data['blocks']);

        return $data;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function buildContentBlocks(Request $request, ?Programme $programme = null): array
    {
        $blocks = [];
        $keptImagePaths = [];

        foreach ($request->input('blocks', []) as $index => $block) {
            $type = $block['type'] ?? 'text';

            if ($type === 'text') {
                if (blank($block['body'] ?? null)) {
                    continue;
                }

                $blocks[] = [
                    'type' => 'text',
                    'body' => trim((string) $block['body']),
                ];

                continue;
            }

            if ($type === 'image') {
                $path = $block['existing_path'] ?? null;
                $uploaded = $request->file("blocks.$index.image");

                if ($uploaded instanceof UploadedFile) {
                    $path = $uploaded->store('programmes/blocks', 'public');
                }

                if (blank($path)) {
                    continue;
                }

                $keptImagePaths[] = $path;
                $blocks[] = [
                    'type' => 'image',
                    'path' => $path,
                    'caption' => filled($block['caption'] ?? null) ? trim((string) $block['caption']) : null,
                ];

                continue;
            }

            if ($type === 'table') {
                $headers = collect(explode('|', (string) ($block['headers_text'] ?? '')))
                    ->map(fn ($header) => trim($header))
                    ->filter()
                    ->values()
                    ->all();

                if ($headers === []) {
                    continue;
                }

                $rows = collect(preg_split('/\R/', (string) ($block['rows_text'] ?? '')) ?: [])
                    ->map(fn ($line) => collect(explode('|', $line))
                        ->map(fn ($cell) => trim($cell))
                        ->values()
                        ->all())
                    ->filter(fn ($row) => filled(array_filter($row)))
                    ->values()
                    ->all();

                $blocks[] = [
                    'type' => 'table',
                    'title' => filled($block['title'] ?? null) ? trim((string) $block['title']) : null,
                    'headers' => $headers,
                    'rows' => $rows,
                ];
            }
        }

        if ($programme) {
            foreach ($programme->content_blocks ?? [] as $existingBlock) {
                if (($existingBlock['type'] ?? null) !== 'image') {
                    continue;
                }

                $path = $existingBlock['path'] ?? null;
                if (filled($path) && ! in_array($path, $keptImagePaths, true)) {
                    $this->deleteStoredImage($path);
                }
            }
        }

        return $blocks;
    }

    private function deleteBlockImages(array $blocks): void
    {
        foreach ($blocks as $block) {
            if (($block['type'] ?? null) === 'image') {
                $this->deleteStoredImage($block['path'] ?? null);
            }
        }
    }

    private function deleteStoredImage(?string $path): void
    {
        if (filled($path) && ! str_starts_with($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
