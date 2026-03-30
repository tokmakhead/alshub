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
Route::get('/haberler', [ContentController::class, 'news'])->name('news');
Route::get('/rehberler', [ContentController::class, 'guidelines'])->name('guidelines');
Route::get('/arama', [ContentController::class, 'search'])->name('search');
Route::get('/uzmanlik-merkezleri', [App\Http\Controllers\ExpertController::class, 'index'])->name('experts.index');
Route::get('/uzmanlik-merkezi/{slug}', [App\Http\Controllers\ExpertController::class, 'show'])->name('experts.show');
Route::get('/icerik/{type}/{slug}', [ContentController::class, 'show'])->name('content.show');

// Temporary execution routes for automated scripts
Route::get('/run-migrations-tmp', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
Route::get('/cleanup-drugs-tmp', [App\Http\Controllers\Admin\DrugController::class, 'cleanupTitles']);

Route::get('/clean-optimize', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return "Bütün cache/optimize dosyaları başarıyla temizlendi! Şimdi RSS testini deneyebilirsin.";
    } catch (\Exception $e) {
        return "Hata: " . $e->getMessage();
    }
});

Route::get('/fix-sources-tmp', function() {
    try {
        $old = \App\Models\SourceRegistry::where('source_name', 'Guidelines (NICE/EAN)')->first();
        
        \App\Models\SourceRegistry::updateOrCreate(
            ['source_name' => 'NICE Guidelines'],
            [
                'source_mode' => 'manual',
                'is_enabled' => true,
                'verification_tier' => 1,
                'official_url' => 'https://www.nice.org.uk/guidance/ng42',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/NICE_Logo.svg/1024px-NICE_Logo.svg.png',
                'notes' => 'National Institute for Health and Care Excellence (UK) official ALS guidelines.'
            ]
        );

        \App\Models\SourceRegistry::updateOrCreate(
            ['source_name' => 'EAN Guidelines'],
            [
                'source_mode' => 'manual',
                'is_enabled' => true,
                'verification_tier' => 1,
                'official_url' => 'https://www.ean.org',
                'logo_url' => 'https://ern-euro-nmd.eu/wp-content/uploads/2018/12/ean-logo.png',
                'notes' => 'European Academy of Neurology official ALS management guidelines.'
            ]
        );

        if ($old) $old->delete();
        
        return "SUCCESS: Guidelines (NICE/EAN) split into NICE and EAN successfully.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

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
    Route::post('trials/{trial}/toggle-status', [ClinicalTrialController::class, 'toggleStatus'])->name('trials.toggle-status');
    Route::post('trials/{trial}/fetch', [ClinicalTrialController::class, 'fetchSingle'])->name('trials.fetch');
    Route::post('trials/{trial}/ai-summary', [ClinicalTrialController::class, 'generateAiSummary'])->name('trials.ai-summary');
    Route::get('/cleanup-drugs', [DrugController::class, 'cleanupTitles'])->name('drugs.cleanup');
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
    Route::post('drugs/{drug}/ai-summary', [DrugController::class, 'generateAiSummary'])->name('drugs.ai-summary');
    Route::post('guidelines/{guideline}/ai-summary', [GuidelineController::class, 'generateAiSummary'])->name('guidelines.ai-summary');
    
    // Additional Drug Actions
    Route::post('drugs/{drug}/toggle-status', [DrugController::class, 'toggleStatus'])->name('drugs.toggle-status');
    
    // Guidelines
    Route::resource('guidelines', GuidelineController::class)->names('guidelines');
    Route::resource('contents', AdminContentController::class)->names('contents')->except(['index', 'deleteAll']);
    Route::post('contents/{content}/translate', [AdminContentController::class, 'translate'])->name('contents.translate');
    
    Route::get('/logs', [ImportLogController::class, 'index'])->name('logs.index');
    Route::delete('/logs/clear', [ImportLogController::class, 'deleteAll'])->name('logs.clear');
    Route::delete('/logs/{log}', [ImportLogController::class, 'destroy'])->name('logs.destroy');
    Route::get('/health', [HealthController::class, 'index'])->name('health.index');

    // Maintenance / Repair
    Route::get('repair-slugs', function() {
        // Force update all slugs to ensure they match the URL patterns
        $trials = \App\Models\ClinicalTrial::all();
        foreach($trials as $t) { $t->slug = \Illuminate\Support\Str::slug($t->title . '-' . $t->nct_id . '-' . $t->id); $t->save(); }
        
        $articles = \App\Models\ResearchArticle::all();
        foreach($articles as $a) { $a->slug = \Illuminate\Support\Str::slug($a->title . '-' . ($a->pmid ?: $a->id)); $a->save(); }
        
        $drugs = \App\Models\Drug::all();
        foreach($drugs as $d) { $d->slug = \Illuminate\Support\Str::slug($d->generic_name . '-' . ($d->brand_name ?: '') . '-' . $d->id); $d->save(); }
        
        $guidelines = \App\Models\Guideline::all();
        foreach($guidelines as $g) { $g->slug = \Illuminate\Support\Str::slug($g->title . '-' . $g->source_org . '-' . $g->id); $g->save(); }
        
        $contents = \App\Models\Content::all();
        foreach($contents as $c) { $c->slug = \Illuminate\Support\Str::slug(($c->original_title ?: $c->translated_title ?: 'news') . '-' . $c->id); $c->save(); }
        
        return "SUCCESS: All slugs (Trials, Articles, Drugs, Guidelines, News) have been FORCE REGENERATED and saved to database.";
    })->name('repair-slugs');

    Route::get('clear-cache', function() {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        return "Cache cleared.";
    })->name('clear-cache');
});

require __DIR__.'/auth.php';
