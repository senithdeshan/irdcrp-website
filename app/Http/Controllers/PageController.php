<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\HomeImage;
use App\Models\HomeVideo;
use App\Models\ImpactMetric;
use App\Models\KeyLeader;
use App\Models\News;
use App\Models\Page;
use App\Models\Programme;
use App\Models\ProcurementNotice;
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
            ->orderBy('group')
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

        $homeImages = Schema::hasTable('home_images')
            ? HomeImage::query()
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
            'homeImages',
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
        $items = Schema::hasTable('procurement_notices')
            ? ProcurementNotice::query()
                ->whereIn('status', ['open', 'closed'])
                ->orderBy('sort_order')
                ->orderByDesc('published_date')
                ->orderByDesc('id')
                ->get()
            : collect();

        return view('procurement', compact('items'));
    }

    public function procurementFile(ProcurementNotice $procurementNotice, int $index): Response|StreamedResponse
    {
        abort_unless(in_array($procurementNotice->status, ['open', 'closed'], true), 404);

        $document = $procurementNotice->documentAt($index);
        abort_unless(is_array($document) && filled($document['path'] ?? null), 404);
        abort_unless(Storage::disk('public')->exists($document['path']), 404);

        return Storage::disk('public')->download(
            $document['path'],
            $document['original_name'] ?? basename($document['path'])
        );
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

    public function faq(): View
    {
        $faqs = Schema::hasTable('faqs')
            ? Faq::query()
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
            : collect($this->fallbackFaqs());

        if ($faqs->isEmpty()) {
            $faqs = collect($this->fallbackFaqs());
        }

        return view('faq', compact('faqs'));
    }

    public function contact(): View
    {
        return view('contact');
    }

    private function fallbackFaqs(): array
    {
        return [
            [
                'question' => 'What is the Integrated Rurban Development and Climate Resilience Project?',
                'answer' => 'IRDCRP supports climate-smart agriculture, rural livelihoods, resilient natural resource management, sector services, and project coordination for targeted communities in Sri Lanka.',
            ],
            [
                'question' => 'Where can I find project documents?',
                'answer' => 'Use the Resources menu and open Documents to view published reports, forms, and official public files.',
            ],
            [
                'question' => 'Where are procurement notices published?',
                'answer' => 'Procurement opportunities are available under Announcements, then Procurement.',
            ],
            [
                'question' => 'How can I submit a complaint or grievance?',
                'answer' => 'Open GRM from the main navigation and complete the complaint form with your contact details and message.',
            ],
            [
                'question' => 'Where can I find vacancies?',
                'answer' => 'Vacancy notices are listed under Announcements, then Vacancy.',
            ],
            [
                'question' => 'How can I contact the project team?',
                'answer' => 'Use Contact Us in the navigation to view contact details and send a support message.',
            ],
        ];
    }
}
