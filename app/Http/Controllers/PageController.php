<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Gallery;
use App\Models\HomeVideo;
use App\Models\ImpactMetric;
use App\Models\KeyLeader;
use App\Models\News;
use App\Models\Page;
use App\Models\Programme;
use App\Models\ProjectComponent;
use App\Models\SuccessStory;
use App\Models\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PageController extends Controller
{
    public function home(): View
    {
        $latestNews = News::query()
            ->where('status', 'published')
            ->latest('published_date')
            ->first();

        $homeNews = News::query()
            ->where('status', 'published')
            ->latest('published_date')
            ->take(3)
            ->get();

        $programmes = Programme::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->take(8)
            ->get();

        $galleryPreview = Gallery::query()
            ->where('category', 'photos')
            ->where('status', 'published')
            ->orderByDesc('item_date')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $vacanciesPreview = Vacancy::query()
            ->whereIn('status', ['open', 'closed'])
            ->orderByDesc('deadline')
            ->get();

        $keyLeaders = KeyLeader::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $successStories = Schema::hasTable('success_stories')
            ? SuccessStory::query()
                ->where('status', 'active')
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $homeVideos = Schema::hasTable('home_videos')
            ? HomeVideo::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
            : collect();

        if ($keyLeaders->isEmpty()) {
            $keyLeaders = collect(config('irdcrp.key_leaders', []));
        }

        $impactMetrics = Schema::hasTable('impact_metrics')
            ? ImpactMetric::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
            : collect();

        return view('home', compact(
            'latestNews',
            'homeNews',
            'programmes',
            'galleryPreview',
            'vacanciesPreview',
            'keyLeaders',
            'successStories',
            'homeVideos',
            'impactMetrics',
        ));
    }

    public function about(): View
    {
        return view('about');
    }

    public function components(): View
    {
        $components = ProjectComponent::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('component_number')
            ->get();

        return view('components', compact('components'));
    }

    public function programmes(): View
    {
        $programmes = Programme::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('programmes.index', compact('programmes'));
    }

    public function showProgramme(Programme $programme): View
    {
        abort_unless($programme->status === 'published' || auth()->check(), 404);

        $moreProgrammes = Programme::query()
            ->where('status', 'published')
            ->whereKeyNot($programme->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('programmes.show', compact('programme', 'moreProgrammes'));
    }

    public function areas(): View
    {
        return view('areas');
    }

    public function news(): View
    {
        $news = News::query()->where('status', 'published')->latest()->get();

        return view('news', compact('news'));
    }

    public function showNews(News $news): View
    {
        abort_unless($news->status === 'published' || auth()->check(), 404);

        return view('news-show', compact('news'));
    }

    public function procurement(): View
    {
        return view('procurement');
    }

    public function downloads(): View
    {
        $downloads = Download::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('downloads', compact('downloads'));
    }

    public function downloadFile(Download $download): RedirectResponse|Response|StreamedResponse
    {
        abort_unless($download->status === 'published', 404);
        if (! Storage::disk('public')->exists($download->file_path)) {
            abort(404, 'File not found.');
        }

        $name = basename($download->file_path);

        return Storage::disk('public')->download($download->file_path, $name);
    }

    public function gallerySection(string $section): View
    {
        if ($section === 'photos') {
            $items = Gallery::query()
                ->where('category', 'photos')
                ->where('status', 'published')
                ->orderByDesc('item_date')
                ->orderByDesc('id')
                ->get();

            return view('gallery.photos', compact('items'));
        }

        $titleKeys = [
            'audio' => 'messages.nav_media_audio',
            'videos' => 'messages.nav_media_videos',
            'presentation' => 'messages.nav_media_presentation',
            'voice' => 'messages.nav_media_voice',
        ];

        $items = Gallery::query()
            ->where('category', $section)
            ->where('status', 'published')
            ->orderByDesc('item_date')
            ->orderByDesc('id')
            ->get();

        return view('gallery.media', [
            'items' => $items,
            'section' => $section,
            'titleKey' => $titleKeys[$section],
        ]);
    }

    public function vacancies(): View
    {
        $items = Vacancy::query()
            ->whereIn('status', ['open', 'closed'])
            ->orderByDesc('deadline')
            ->get();

        return view('vacancies', compact('items'));
    }

    public function showVacancy(Vacancy $vacancy): View
    {
        abort_unless($vacancy->status !== 'draft' || auth()->check(), 404);

        return view('vacancy-show', compact('vacancy'));
    }

    public function showCmsPage(Page $page): View
    {
        abort_unless($page->status === 'published' || auth()->check(), 404);

        return view('page-show', compact('page'));
    }

    public function grm(): View
    {
        return view('grm');
    }

    public function contact(): View
    {
        return view('contact');
    }
}
