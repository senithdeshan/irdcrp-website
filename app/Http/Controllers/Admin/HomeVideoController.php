<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class HomeVideoController extends Controller
{
    public function index(): View
    {
        $items = HomeVideo::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.home-videos.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.home-videos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateVideo($request);
        $data['section_key'] = 'general';
        $data['youtube_id'] = $this->extractYoutubeId($data['youtube_url']);

        HomeVideo::create($data);

        return redirect()->route('admin.home-videos.index')->with('success', 'Home video added.');
    }

    public function edit(HomeVideo $homeVideo): View
    {
        return view('admin.home-videos.edit', compact('homeVideo'));
    }

    public function update(Request $request, HomeVideo $homeVideo): RedirectResponse
    {
        $data = $this->validateVideo($request);
        $data['section_key'] = 'general';
        $data['youtube_id'] = $this->extractYoutubeId($data['youtube_url']);

        $homeVideo->update($data);

        return redirect()->route('admin.home-videos.index')->with('success', 'Home video updated.');
    }

    public function destroy(HomeVideo $homeVideo): RedirectResponse
    {
        $homeVideo->delete();

        return redirect()->route('admin.home-videos.index')->with('success', 'Home video deleted.');
    }

    private function validateVideo(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'bullet_one' => ['nullable', 'string', 'max:255'],
            'bullet_two' => ['nullable', 'string', 'max:255'],
            'bullet_three' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['required', 'url', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function extractYoutubeId(string $url): string
    {
        $url = trim($url);
        $parts = parse_url($url);
        $host = strtolower($parts['host'] ?? '');
        $path = trim((string) ($parts['path'] ?? ''), '/');

        $id = null;

        if (str_contains($host, 'youtu.be')) {
            $id = $path !== '' ? explode('/', $path)[0] : null;
        } elseif (str_contains($host, 'youtube.com')) {
            if (str_starts_with($path, 'watch')) {
                parse_str((string) ($parts['query'] ?? ''), $query);
                $id = $query['v'] ?? null;
            } elseif (str_starts_with($path, 'embed/')) {
                $id = explode('/', $path)[1] ?? null;
            } elseif (str_starts_with($path, 'shorts/')) {
                $id = explode('/', $path)[1] ?? null;
            } elseif (str_starts_with($path, 'live/')) {
                $id = explode('/', $path)[1] ?? null;
            }
        }

        if (! is_string($id) || ! preg_match('/^[A-Za-z0-9_-]{11}$/', $id)) {
            throw ValidationException::withMessages([
                'youtube_url' => 'Please provide a valid YouTube video URL.',
            ]);
        }

        return $id;
    }
}

