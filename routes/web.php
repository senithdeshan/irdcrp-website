<?php

use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\KeyLeaderController;
use App\Http\Controllers\Admin\SuccessStoryController;
use App\Http\Controllers\Admin\VacancyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/components', [PageController::class, 'components']);
Route::get('/areas', [PageController::class, 'areas']);
Route::get('/news', [PageController::class, 'news'])->name('news.index');
Route::get('/news/{news}', [PageController::class, 'showNews'])->name('news.show');
Route::get('/procurement', [PageController::class, 'procurement']);
Route::get('/downloads', [PageController::class, 'downloads'])->name('downloads.index');
Route::get('/downloads/file/{download}', [PageController::class, 'downloadFile'])->name('download.file');
Route::get('/gallery', function () {
    return redirect()->route('gallery.section', ['section' => 'photos']);
})->name('gallery.index');
Route::get('/gallery/{section}', [PageController::class, 'gallerySection'])
    ->whereIn('section', ['audio', 'photos', 'videos', 'presentation', 'voice'])
    ->name('gallery.section');
Route::get('/vacancies', [PageController::class, 'vacancies'])->name('vacancies.index');
Route::get('/vacancies/{vacancy}', [PageController::class, 'showVacancy'])->name('vacancies.show');
Route::get('/grm', [PageController::class, 'grm']);
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/p/{page:slug}', [PageController::class, 'showCmsPage'])->name('page.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    Route::resource('gallery', GalleryController::class)->except(['show']);
    Route::resource('vacancies', VacancyController::class)->except(['show']);
    Route::resource('downloads', DownloadController::class)->except(['show']);
    Route::resource('pages', CmsPageController::class)->except(['show']);
    Route::resource('key-leaders', KeyLeaderController::class)->except(['show']);
    Route::resource('success-stories', SuccessStoryController::class)->except(['show']);
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'si', 'ta'])) {
        session(['locale' => $locale]);
    }

    return back();
});

require __DIR__.'/auth.php';
