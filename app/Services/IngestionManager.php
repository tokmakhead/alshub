<?php

namespace App\Services;

use App\Models\SourceRegistry;
use App\Models\IngestionLog;
use App\Models\ResearchArticle;
use App\Models\ClinicalTrial;
use App\Services\Adapters\PubMedAdapter;
use App\Services\Adapters\ClinicalTrialsAdapter;
use App\Services\Normalizers\ContentNormalizer;
use Illuminate\Support\Facades\Log;

class IngestionManager
{
    protected $pubMed;
    protected $trials;
    protected $drugAdapter;
    protected $normalizer;

    public function __construct(
        PubMedAdapter $pubMed,
        ClinicalTrialsAdapter $trials,
        \App\Services\Adapters\DrugAdapter $drugAdapter,
        ContentNormalizer $normalizer
    ) {
        $this->pubMed = $pubMed;
        $this->trials = $trials;
        $this->drugAdapter = $drugAdapter;
        $this->normalizer = $normalizer;
    }

    /**
     * Run all active API sources.
     */
    public function syncAll()
    {
        $sources = SourceRegistry::where('is_enabled', true)
            ->where('source_mode', 'api')
            ->get();

        foreach ($sources as $source) {
            switch ($source->source_name) {
                case 'PubMed':
                    $this->syncPubMed($source);
                    break;
                case 'ClinicalTrials.gov':
                    $this->syncTrials($source);
                    break;
                case 'OpenFDA':
                    $this->syncDrugs($source);
                    break;
            }
        }
    }

    /**
     * Run ingestion for PubMed using search API + Details fetch.
     */
    public function syncPubMed(SourceRegistry $source = null)
    {
        $query = $source->config_json['default_query'] ?? 'Amyotrophic Lateral Sclerosis';
        
        $log = IngestionLog::create([
            'source_name' => 'PubMed',
            'content_type' => 'research',
            'status' => 'started',
            'started_at' => now(),
        ]);

        try {
            // Step 1: Search for IDs (Official API)
            $ids = $this->pubMed->search($query, 15);
            
            // Step 2: Fetch Details (Official API)
            $xml = $this->pubMed->fetchDetails($ids);
            
            // Step 3: Normalize & Insert
            $normalizedItems = $this->normalizer->normalizePubMed($xml);

            $inserted = 0;
            $updated = 0;

            foreach ($normalizedItems as $data) {
                $article = ResearchArticle::updateOrCreate(
                    ['pmid' => $data['pmid']],
                    array_merge($data, [
                        'status' => 'draft',
                        'verification_tier' => 1,
                        'fetched_at' => now()
                    ])
                );

                if ($article->wasRecentlyCreated) {
                    $inserted++;
                } else {
                    $updated++;
                }
            }

            $log->update([
                'status' => 'success',
                'fetched_count' => count($ids),
                'inserted_count' => $inserted,
                'updated_count' => $updated,
                'finished_at' => now(),
            ]);

            if ($source) $source->update(['last_successful_sync' => now()]);

            return $log;

        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'finished_at' => now(),
            ]);
            if ($source) $source->update(['last_failed_sync' => now()]);
            Log::error('PubMed Official Sync Failed', ['error' => $e->getMessage()]);
            return $log;
        }
    }

    /**
     * Run ingestion for ClinicalTrials (Official API v2).
     */
    public function syncTrials(SourceRegistry $source = null)
    {
        $query = $source->config_json['default_query'] ?? 'Amyotrophic Lateral Sclerosis';

        $log = IngestionLog::create([
            'source_name' => 'ClinicalTrials.gov',
            'content_type' => 'trial',
            'status' => 'started',
            'started_at' => now(),
        ]);

        try {
            // Official API v2 fetch
            $studies = $this->trials->fetchTrials($query, 15);
            
            $inserted = 0;
            $updated = 0;

            foreach ($studies as $study) {
                $data = $this->normalizer->normalizeTrial($study);
                
                $trial = ClinicalTrial::updateOrCreate(
                    ['nct_id' => $data['nct_id']],
                    array_merge($data, [
                        'status' => 'draft',
                        'verification_tier' => 1,
                        'fetched_at' => now()
                    ])
                );

                if ($trial->wasRecentlyCreated) {
                    $inserted++;
                } else {
                    $updated++;
                }
            }

            $log->update([
                'status' => 'success',
                'fetched_count' => count($studies),
                'inserted_count' => $inserted,
                'updated_count' => $updated,
                'finished_at' => now(),
            ]);

            if ($source) $source->update(['last_successful_sync' => now()]);

            return $log;

        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'finished_at' => now(),
            ]);
            if ($source) $source->update(['last_failed_sync' => now()]);
            Log::error('ClinicalTrials Official Sync Failed', ['error' => $e->getMessage()]);
            return $log;
        }
    }

    /**
     * Run ingestion for Drugs (OpenFDA Official API).
     */
    public function syncDrugs(SourceRegistry $source = null)
    {
        $log = IngestionLog::create([
            'source_name' => 'OpenFDA',
            'content_type' => 'drug',
            'status' => 'started',
            'started_at' => now(),
        ]);

        try {
            $results = $this->drugAdapter->searchALS();
            
            $inserted = 0;
            $updated = 0;

            foreach ($results as $item) {
                $data = $this->normalizer->normalizeDrug($item);
                
                $drug = \App\Models\Drug::updateOrCreate(
                    ['generic_name' => $data['generic_name']],
                    [
                        'brand_name' => $data['brand_name'],
                        'slug' => $data['slug'],
                        'status' => 'draft',
                        'verification_tier' => 1
                    ]
                );

                \App\Models\DrugRegionalStatus::updateOrCreate(
                    [
                        'drug_id' => $drug->id,
                        'region' => $data['region_status']['region']
                    ],
                    array_merge($data['region_status'], ['fetched_at' => now()])
                );
                
                if ($drug->wasRecentlyCreated) {
                    $inserted++;
                } else {
                    $updated++;
                }
            }

            $log->update([
                'status' => 'success',
                'fetched_count' => count($results),
                'inserted_count' => $inserted,
                'updated_count' => $updated,
                'finished_at' => now(),
            ]);

            if ($source) $source->update(['last_successful_sync' => now()]);

            return $log;

        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'finished_at' => now(),
            ]);
            if ($source) $source->update(['last_failed_sync' => now()]);
            Log::error('Drug Official Sync Failed', ['error' => $e->getMessage()]);
            return $log;
        }
    }
}
