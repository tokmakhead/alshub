<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\ImportLogController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/als-nedir', [HomeController::class, 'aboutAls'])->name('about.als');
Route::get('/arastirmalar', [ContentController::class, 'publications'])->name('publications');
Route::get('/klinik-calismalar', [ContentController::class, 'trials'])->name('trials');
Route::get('/ilaclar', [ContentController::class, 'drugs'])->name('drugs');
Route::get('/arama', [ContentController::class, 'search'])->name('search');
Route::get('/icerik/{slug}', [ContentController::class, 'show'])->name('content.show');
Route::get('/hakkimizda', [HomeController::class, 'aboutUs'])->name('about.us');
Route::get('/iletisim', [HomeController::class, 'contact'])->name('contact');
Route::get('/politika', [HomeController::class, 'policy'])->name('policy');

// Auth Routes (Breeze)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sources', SourceController::class);
    Route::post('sources/{source}/fetch', [SourceController::class, 'fetchNow'])->name('sources.fetch');
    Route::get('sources/{source}/progress', [SourceController::class, 'checkProgress'])->name('sources.progress');
    Route::delete('contents/delete-all', [AdminContentController::class, 'deleteAll'])->name('contents.delete-all');
    Route::resource('contents', AdminContentController::class)->names('contents')->except(['create', 'store']);
    Route::post('contents/{content}/translate', [AdminContentController::class, 'translate'])->name('contents.translate');
    Route::get('/logs', [ImportLogController::class, 'index'])->name('logs.index');
});

require __DIR__.'/auth.php';
