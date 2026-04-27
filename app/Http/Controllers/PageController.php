<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Gallery;
use App\Models\KeyLeader;
use App\Models\News;
use App\Models\Page;
use App\Models\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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

        $galleryPreview = Gallery::query()
            ->orderByDesc('item_date')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $vacanciesPreview = Vacancy::query()
            ->where('status', 'open')
            ->whereDate('deadline', '>=', now())
            ->orderBy('deadline')
            ->take(3)
            ->get();

        $keyLeaders = KeyLeader::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($keyLeaders->isEmpty()) {
            $keyLeaders = collect(config('irdcrp.key_leaders', []));
        }

        return view('home', compact(
            'latestNews',
            'homeNews',
            'galleryPreview',
            'vacanciesPreview',
            'keyLeaders',
        ));
    }

    public function about(): View
    {
        return view('about');
    }

    public function components(): View
    {
        return view('components');
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

    public function gallery(): View
    {
        $items = Gallery::query()
            ->orderByDesc('item_date')
            ->orderByDesc('id')
            ->get();

        return view('gallery', compact('items'));
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
