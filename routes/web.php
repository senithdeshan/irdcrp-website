<?php


use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/components', [PageController::class, 'components']);
Route::get('/areas', [PageController::class, 'areas']);
Route::get('/news', [PageController::class, 'news']);
Route::get('/procurement', [PageController::class, 'procurement']);
Route::get('/downloads', [PageController::class, 'downloads']);
Route::get('/gallery', [PageController::class, 'gallery']);
Route::get('/grm', [PageController::class, 'grm']);
Route::get('/contact', [PageController::class, 'contact']);