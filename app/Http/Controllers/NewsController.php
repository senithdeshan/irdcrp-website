<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_si' => 'nullable|string|max:255',
            'title_ta' => 'nullable|string|max:255',
            'content_en' => 'required|string',
            'content_si' => 'nullable|string',
            'content_ta' => 'nullable|string',
            'published_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'images' => 'nullable|array|max:20',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        $imagePaths = $this->storeImages($request);
        $data['image'] = $imagePaths[0] ?? null;
        $data['images'] = $imagePaths;

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_si' => 'nullable|string|max:255',
            'title_ta' => 'nullable|string|max:255',
            'content_en' => 'required|string',
            'content_si' => 'nullable|string',
            'content_ta' => 'nullable|string',
            'published_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'images' => 'nullable|array|max:20',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:8192',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string',
        ]);

        $imagePaths = collect($news->imagePaths());
        $removeImages = collect($data['remove_images'] ?? [])->filter()->values();

        if ($removeImages->isNotEmpty()) {
            $imagePaths = $imagePaths->reject(fn (string $path) => $removeImages->contains($path))->values();
            $removeImages->each(fn (string $path) => $this->deleteStoredImage($path));
        }

        $imagePaths = $imagePaths
            ->merge($this->storeImages($request))
            ->unique()
            ->values();

        unset($data['remove_images']);
        $data['image'] = $imagePaths->first();
        $data['images'] = $imagePaths->all();

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        collect($news->imagePaths())->each(fn (string $path) => $this->deleteStoredImage($path));

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }

    private function storeImages(Request $request): array
    {
        if (! $request->hasFile('images')) {
            return [];
        }

        return collect($request->file('images'))
            ->filter()
            ->map(fn ($image) => $image->store('news', 'public'))
            ->values()
            ->all();
    }

    private function deleteStoredImage(string $path): void
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'images/')) {
            return;
        }

        Storage::disk('public')->delete(preg_replace('#^/?storage/#', '', ltrim($path, '/')));
    }
}
