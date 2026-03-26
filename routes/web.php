<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\ImportLogController;
use App\Http\Controllers\Admin\ResearchArticleController;
use App\Http\Controllers\Admin\ClinicalTrialController;
use App\Http\Controllers\Admin\DrugController;
use App\Http\Controllers\Admin\ExpertCenterController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\GuidelineController;
use App\Http\Controllers\Admin\HealthController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/als-nedir', [HomeController::class, 'aboutAls'])->name('about.als');
Route::get('/arastirmalar', [ContentController::class, 'publications'])->name('publications');
Route::get('/klinik-calismalar', [ContentController::class, 'trials'])->name('trials');
Route::get('/ilaclar', [ContentController::class, 'drugs'])->name('drugs');
Route::get('/rehberler', [ContentController::class, 'guidelines'])->name('guidelines');
Route::get('/arama', [ContentController::class, 'search'])->name('search');
Route::get('/icerik/{type}/{slug}', [ContentController::class, 'show'])->name('content.show');

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
    // Source Registry Management (api.md Alignment)
    Route::get('/sources', [SourceController::class, 'index'])->name('sources.index');
    Route::get('/sources/create', [SourceController::class, 'create'])->name('sources.create');
    Route::post('/sources', [SourceController::class, 'store'])->name('sources.store');
    Route::get('/sources/{source}/edit', [SourceController::class, 'edit'])->name('sources.edit');
    Route::put('/sources/{source}', [SourceController::class, 'update'])->name('sources.update');
    Route::delete('/sources/{source}', [SourceController::class, 'destroy'])->name('sources.destroy');
    Route::post('/sources/{source}/fetch', [SourceController::class, 'fetchNow']);
    Route::get('/sources/{source}/progress', [SourceController::class, 'checkProgress']);

    // New Scientific Content Routes
    Route::resource('research', ResearchArticleController::class);
    Route::resource('trials', ClinicalTrialController::class);
    Route::resource('drugs', DrugController::class);

    // Archive / Legacy
    Route::get('legacy', [AdminContentController::class, 'index'])->name('contents.index');
    Route::delete('contents/delete-all', [AdminContentController::class, 'deleteAll'])->name('contents.delete-all');
    // Expert Profiles
    Route::resource('expert-centers', ExpertCenterController::class)->names('expert-centers');
    Route::resource('doctors', DoctorController::class)->names('doctors');
    
    // AI Summary Generation
    Route::post('research/{researchArticle}/ai-summary', [ResearchArticleController::class, 'generateAiSummary'])->name('research.ai-summary');
    Route::post('trials/{clinicalTrial}/ai-summary', [ClinicalTrialController::class, 'generateAiSummary'])->name('trials.ai-summary');
    Route::post('guidelines/{guideline}/ai-summary', [GuidelineController::class, 'generateAiSummary'])->name('guidelines.ai-summary');
    
    // Guidelines
    Route::resource('guidelines', GuidelineController::class)->names('guidelines');
    Route::resource('contents', AdminContentController::class)->names('contents')->except(['index', 'create', 'store', 'deleteAll']);
    Route::post('contents/{content}/translate', [AdminContentController::class, 'translate'])->name('contents.translate');
    
    Route::get('/logs', [ImportLogController::class, 'index'])->name('logs.index');
    Route::delete('/logs/clear', [ImportLogController::class, 'deleteAll'])->name('logs.clear');
    Route::delete('/logs/{log}', [ImportLogController::class, 'destroy'])->name('logs.destroy');
    Route::get('/health', [HealthController::class, 'index'])->name('health.index');
});

require __DIR__.'/auth.php';
