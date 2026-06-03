<?php

use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GrmComplaintController as AdminGrmComplaintController;
use App\Http\Controllers\Admin\HomeImageController;
use App\Http\Controllers\Admin\HomeVideoController;
use App\Http\Controllers\Admin\ImpactMetricController;
use App\Http\Controllers\Admin\KeyLeaderController;
use App\Http\Controllers\Admin\LatestInsightController;
use App\Http\Controllers\Admin\ProgrammeController as AdminProgrammeController;
use App\Http\Controllers\Admin\OtherAnnouncementController;
use App\Http\Controllers\Admin\ProcurementNoticeController;
use App\Http\Controllers\Admin\ProjectComponentController;
use App\Http\Controllers\Admin\SafeguardResourceController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SupportMessageController as AdminSupportMessageController;
use App\Http\Controllers\Admin\SuccessStoryController;
use App\Http\Controllers\Admin\VacancyController;
use App\Http\Controllers\GrmComplaintController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SafeguardController;
use App\Http\Controllers\SupportMessageController;
use App\Http\Middleware\EnsureSuperAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/components', [PageController::class, 'components']);
Route::get('/programmes', [PageController::class, 'programmes'])->name('programmes.index');
Route::get('/programmes/{programme:slug}', [PageController::class, 'showProgramme'])->name('programmes.show');
Route::get('/areas', [PageController::class, 'areas']);
Route::get('/news', [PageController::class, 'news'])->name('news.index');
Route::get('/news/{news}', [PageController::class, 'showNews'])->name('news.show');
Route::get('/procurement', [PageController::class, 'procurement'])->name('procurement.index');
Route::get('/procurement/file/{procurementNotice}/{index}', [PageController::class, 'procurementFile'])
    ->whereNumber('index')
    ->name('procurement.file');
Route::get('/downloads', [PageController::class, 'downloads'])->name('downloads.index');
Route::get('/downloads/file/{download}', [PageController::class, 'downloadFile'])->name('download.file');
Route::get('/safeguards/{category}', [SafeguardController::class, 'show'])->name('safeguards.show');
Route::get('/safeguards/file/{safeguard}', [SafeguardController::class, 'download'])->name('safeguards.download');
Route::get('/gallery', function () {
    return redirect()->route('gallery.section', ['section' => 'photos']);
})->name('gallery.index');
Route::get('/gallery/{section}', [PageController::class, 'gallerySection'])
    ->whereIn('section', ['audio', 'photos', 'videos', 'presentation', 'voice'])
    ->name('gallery.section');
Route::get('/vacancies', [PageController::class, 'vacancies'])->name('vacancies.index');
Route::get('/vacancies/{vacancy}', [PageController::class, 'showVacancy'])->name('vacancies.show');
Route::get('/announcements/other', [PageController::class, 'otherAnnouncements'])->name('other-announcements.index');
Route::get('/announcements/other/file/{otherAnnouncement}', [PageController::class, 'otherAnnouncementFile'])->name('other-announcements.file');
Route::get('/announcements/other/{otherAnnouncement}', [PageController::class, 'showOtherAnnouncement'])->name('other-announcements.show');
Route::get('/grm', [PageController::class, 'grm']);
Route::post('/grm/complaints', [GrmComplaintController::class, 'store'])->name('grm.complaints.store');
Route::get('/faq', [PageController::class, 'faq']);
Route::get('/contact', [PageController::class, 'contact']);
Route::post('/contact/support', [SupportMessageController::class, 'store'])->name('support-messages.store');
Route::get('/p/{page:slug}', [PageController::class, 'showCmsPage'])->name('page.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', EnsureSuperAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    Route::resource('programmes', AdminProgrammeController::class)->except(['show']);
    Route::resource('gallery', GalleryController::class)->except(['show']);
    Route::resource('vacancies', VacancyController::class)->except(['show']);
    Route::resource('procurement-notices', ProcurementNoticeController::class)->except(['show']);
    Route::resource('other-announcements', OtherAnnouncementController::class)->except(['show']);
    Route::resource('downloads', DownloadController::class)->except(['show']);
    Route::resource('safeguards', SafeguardResourceController::class)->except(['show']);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('pages', CmsPageController::class)->except(['show']);
    Route::resource('project-components', ProjectComponentController::class)->except(['show']);
    Route::resource('key-leaders', KeyLeaderController::class)->except(['show']);
    Route::resource('latest-insights', LatestInsightController::class)->except(['show']);
    Route::resource('success-stories', SuccessStoryController::class)->except(['show']);
    Route::resource('home-images', HomeImageController::class)->only(['index', 'edit', 'update']);
    Route::resource('home-videos', HomeVideoController::class)->except(['show']);
    Route::get('site-settings', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::get('about-page', [AboutPageController::class, 'edit'])->name('about-page.edit');
    Route::put('about-page', [AboutPageController::class, 'update'])->name('about-page.update');
    Route::get('impact-metrics', [ImpactMetricController::class, 'index'])->name('impact-metrics.index');
    Route::put('impact-metrics', [ImpactMetricController::class, 'update'])->name('impact-metrics.update');
    Route::get('grm-complaints', [AdminGrmComplaintController::class, 'index'])->name('grm-complaints.index');
    Route::get('grm-complaints/{grmComplaint}/edit', [AdminGrmComplaintController::class, 'edit'])->name('grm-complaints.edit');
    Route::put('grm-complaints/{grmComplaint}', [AdminGrmComplaintController::class, 'update'])->name('grm-complaints.update');
    Route::get('support-messages', [AdminSupportMessageController::class, 'index'])->name('support-messages.index');
    Route::get('support-messages/{supportMessage}/edit', [AdminSupportMessageController::class, 'edit'])->name('support-messages.edit');
    Route::put('support-messages/{supportMessage}', [AdminSupportMessageController::class, 'update'])->name('support-messages.update');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'si', 'ta'])) {
        session(['locale' => $locale]);
    }

    return back();
});

require __DIR__.'/auth.php';
