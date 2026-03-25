<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IngestionManager;

class SyncAllSources extends Command
{
    protected $signature = 'sync:all';
    protected $description = 'Sync all enabled high-trust sources (PubMed, ClinicalTrials, FDA)';

    public function handle(IngestionManager $manager)
    {
        $this->info('Starting global sync process...');
        $manager->syncAll();
        $this->info('Global sync completed.');
        return 0;
    }
}
