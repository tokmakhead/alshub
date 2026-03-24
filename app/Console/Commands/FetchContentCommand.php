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
    }
}
