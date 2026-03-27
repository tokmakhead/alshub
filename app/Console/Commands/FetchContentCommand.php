<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Source;
use App\Models\Content;
use App\Services\ContentFetcherService;
use App\Services\TranslationService;

class FetchContentCommand extends Command
{
    protected $signature = 'als:fetch-content';
    protected $description = 'Fetch content from active sources and translate drafts';

    public function handle(ContentFetcherService $fetcher, TranslationService $translator)
    {
        $sources = Source::where('is_active', true)->get();
        $this->info("Fetching from " . $sources->count() . " sources...");

        foreach ($sources as $source) {
            $this->comment("Fetching: " . $source->name);
            $fetcher->fetchFromSource($source);
        }

        $drafts = Content::where('status', 'draft')->get();
        $this->info("Translating " . $drafts->count() . " drafts...");

        foreach ($drafts as $draft) {
            $translator->translate($draft);
        }

        $this->info("Fetching and translation complete.");

        // Log to database for Admin visibility
        \App\Models\ImportLog::create([
            'status' => 'success',
            'message' => "Genel senkronizasyon ve çeviri işlemi tamamlandı. ({$sources->count()} kaynak, {$drafts->count()} çeviri)",
            'payload' => [
                'source_count' => $sources->count(),
                'translation_count' => $drafts->count(),
                'command' => 'als:fetch-content'
            ]
        ]);
    }
}
