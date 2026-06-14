<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\CercDocument;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\GrmComplaint;
use App\Models\HomeImage;
use App\Models\HomeVideo;
use App\Models\ImpactMetric;
use App\Models\KeyLeader;
use App\Models\LatestInsight;
use App\Models\News;
use App\Models\OtherAnnouncement;
use App\Models\Page;
use App\Models\Programme;
use App\Models\ProjectPartner;
use App\Models\ProjectComponent;
use App\Models\ProcurementNotice;
use App\Models\SuccessStory;
use App\Models\Vacancy;
use App\Support\PublicFileDownload;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            ->orderByDesc('is_pinned')
            ->latest('published_date')
            ->latest('id')
            ->first();

        $homeNews = News::query()
            ->where('status', 'published')
            ->orderByDesc('is_pinned')
            ->latest('published_date')
            ->latest('id')
            ->take(3)
            ->get();

        $programmes = Programme::query()
            ->with('projectComponent')
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->take(8)
            ->get();

        $galleryPreview = Gallery::query()
            ->where('category', 'photos')
            ->where('status', 'published')
            ->orderedForDisplay()
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

        $latestInsights = Schema::hasTable('latest_insights')
            ? LatestInsight::query()
                ->where('status', 'active')
                ->latest('insight_date')
                ->latest()
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
                ->visibleOnHome()
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

        $homeBlocks = app(SiteSettings::class)->homeBlocksForPublic();
        $projectIdentity = app(SiteSettings::class)->homeIdentityForPublic();
        $heroSlideIntervalMs = app(SiteSettings::class)->homeHeroSlideIntervalMs();
        $weatherLocale = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
        $weatherWidget = app(SiteSettings::class)->weatherWidget($weatherLocale);

        $projectPartners = Schema::hasTable('project_partners')
            ? ProjectPartner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
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
            'latestInsights',
            'homeVideos',
            'homeImages',
            'impactMetrics',
            'homeBlocks',
            'projectIdentity',
            'heroSlideIntervalMs',
            'projectPartners',
            'weatherWidget',
        ));
    }

    public function about(SiteSettings $settings): View
    {
        return view('about', [
            'about' => $settings->aboutPageForPublic(),
        ]);
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

    public function programmes(Request $request): View
    {
        $components = ProjectComponent::query()
            ->where('status', 'published')
            ->orderBy('component_number')
            ->get();

        $selectedComponent = null;
        if ($request->filled('component')) {
            $selectedComponent = $components->firstWhere(
                'component_number',
                (int) $request->query('component'),
            );
        }

        $programmes = Programme::query()
            ->with('projectComponent')
            ->where('status', 'published')
            ->when(
                $selectedComponent,
                fn ($query) => $query->where('project_component_id', $selectedComponent->id),
            )
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('programmes.index', compact('programmes', 'components', 'selectedComponent'));
    }

    public function showProgramme(Programme $programme): View
    {
        abort_unless($programme->status === 'published' || auth()->check(), 404);

        $programme->load('projectComponent');

        $moreProgrammes = Programme::query()
            ->with('projectComponent')
            ->where('status', 'published')
            ->whereKeyNot($programme->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('programmes.show', compact('programme', 'moreProgrammes'));
    }

    public function areas(SiteSettings $settings): View
    {
        return view('areas', [
            'projectAreas' => $settings->projectAreas(),
        ]);
    }

    public function news(): View
    {
        $news = News::query()
            ->where('status', 'published')
            ->orderByDesc('is_pinned')
            ->latest('published_date')
            ->latest('id')
            ->get();

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

        return PublicFileDownload::fromPublicDisk(
            $document['path'],
            $document['original_name'] ?? basename($document['path']),
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

    public function cerc(): View
    {
        $cerc = app(SiteSettings::class)->cercPage();
        $component = ProjectComponent::query()
            ->where('status', 'published')
            ->where(function ($query): void {
                $query
                    ->where('component_number', 5)
                    ->orWhere('title', 'like', '%Contingent Emergency Response%')
                    ->orWhere('title', 'like', '%CERC%');
            })
            ->orderBy('sort_order')
            ->first();

        $documents = CercDocument::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('cerc', compact('cerc', 'component', 'documents'));
    }

    public function downloadFile(Download $download): RedirectResponse|Response|StreamedResponse
    {
        abort_unless($download->status === 'published', 404);
        if (! Storage::disk('public')->exists($download->file_path)) {
            abort(404, 'File not found.');
        }

        return PublicFileDownload::fromPublicDisk(
            $download->file_path,
            PublicFileDownload::downloadName($download->file_original_name, $download->title, $download->file_path),
        );
    }

    public function cercFile(CercDocument $cercDocument): Response|StreamedResponse
    {
        abort_unless($cercDocument->status === 'published', 404);
        abort_unless($cercDocument->fileExists(), 404);

        return PublicFileDownload::fromPublicDisk(
            $cercDocument->file_path,
            PublicFileDownload::downloadName($cercDocument->file_original_name, $cercDocument->title, $cercDocument->file_path),
        );
    }

    public function vacancyFile(Vacancy $vacancy): Response|StreamedResponse
    {
        abort_unless(in_array($vacancy->status, ['open', 'closed'], true), 404);
        abort_unless(filled($vacancy->pdf_path), 404);

        return PublicFileDownload::fromPublicDisk($vacancy->pdf_path, $vacancy->pdfDownloadName());
    }

    public function gallerySection(string $section): View
    {
        if ($section === 'photos') {
            $items = Gallery::query()
                ->where('category', 'photos')
                ->where('status', 'published')
                ->orderedForDisplay()
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
            ->orderedForDisplay()
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

    public function otherAnnouncements(): View
    {
        $items = Schema::hasTable('other_announcements')
            ? OtherAnnouncement::query()
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->orderByDesc('published_date')
                ->orderByDesc('id')
                ->get()
            : collect();

        return view('other-announcements', compact('items'));
    }

    public function showOtherAnnouncement(OtherAnnouncement $otherAnnouncement): View
    {
        abort_unless($otherAnnouncement->status === 'published', 404);

        return view('other-announcement-show', compact('otherAnnouncement'));
    }

    public function otherAnnouncementFile(OtherAnnouncement $otherAnnouncement): Response|StreamedResponse
    {
        abort_unless($otherAnnouncement->status === 'published', 404);
        abort_unless($otherAnnouncement->documentExists(), 404);

        return PublicFileDownload::fromPublicDisk(
            $otherAnnouncement->document_path,
            $otherAnnouncement->document_original_name ?: basename($otherAnnouncement->document_path),
        );
    }

    public function showCmsPage(Page $page): View|RedirectResponse
    {
        abort_unless($page->status === 'published' || auth()->check(), 404);

        if ($page->slug === 'organizational-structure') {
            return redirect()->route('organizational-structure');
        }

        if ($page->slug === 'reports') {
            return redirect()->route('reports.index');
        }

        if ($page->slug === 'institutional-development') {
            return redirect()->route('institutional-development.index');
        }

        return view('page-show', compact('page'));
    }

    public function organizationalStructure(): View
    {
        $projectStaff = KeyLeader::query()
            ->where('is_active', true)
            ->where('group', 'project_staff')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $structure = app(SiteSettings::class)->organizationalStructure();

        return view('organizational-structure', [
            'projectStaff' => $projectStaff,
            'structure' => $structure,
            'structureImageUrl' => app(SiteSettings::class)->organizationalStructureImageUrl($structure['image'] ?? null),
            'staffFallbackImageUrl' => app(SiteSettings::class)->organizationalStructureImageUrl($structure['staff_fallback_image'] ?? null),
        ]);
    }

    public function grm(): View
    {
        $grmStats = Schema::hasTable('grm_complaints')
            ? GrmComplaint::summaryStats()
            : ['total' => 0, 'solved' => 0, 'in_progress' => 0, 'unsolved' => 0];

        return view('grm', compact('grmStats'));
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
