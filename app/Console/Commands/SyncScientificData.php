<?php

namespace App\Console\Commands;

use App\Services\IngestionManager;
use Illuminate\Console\Command;

class SyncScientificData extends Command
{
    protected $signature = 'als:sync-scientific {--source=all : pubmed, trials, or all} {--limit=20 : number of items to fetch}';
    protected $description = 'Fetch scientific data from PubMed and ClinicalTrials.gov';

    protected $ingestionManager;

    public function __construct(IngestionManager $ingestionManager)
    {
        parent::__construct();
        $this->ingestionManager = $ingestionManager;
    }

    public function handle()
    {
        $source = $this->option('source');
        $limit = $this->option('limit');

        if ($source === 'pubmed' || $source === 'all') {
            $this->info('Starting PubMed sync...');
            $log = $this->ingestionManager->syncPubMed('Amyotrophic Lateral Sclerosis', $limit);
            $this->displayLog($log);
        }

        if ($source === 'trials' || $source === 'all') {
            $this->info('Starting ClinicalTrials sync...');
            $log = $this->ingestionManager->syncTrials('Amyotrophic Lateral Sclerosis', $limit);
            $this->displayLog($log);
        }

        $this->info('Sync process completed.');
    }

    private function displayLog($log)
    {
        if ($log->status === 'success') {
            $this->info("Completed: Fetched {$log->fetched_count}, Inserted {$log->inserted_count}, Updated {$log->updated_count}");
        } else {
            $this->error("Failed: {$log->error_message}");
        }
    }
}
