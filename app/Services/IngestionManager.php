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
    protected $normalizer;

    public function __construct(
        PubMedAdapter $pubMed,
        ClinicalTrialsAdapter $trials,
        ContentNormalizer $normalizer
    ) {
        $this->pubMed = $pubMed;
        $this->trials = $trials;
        $this->normalizer = $normalizer;
    }

    /**
     * Run ingestion for PubMed.
     */
    public function syncPubMed($query = 'Amyotrophic Lateral Sclerosis', $limit = 20)
    {
        $log = IngestionLog::create([
            'source_name' => 'PubMed',
            'content_type' => 'research',
            'status' => 'started',
            'started_at' => now(),
        ]);

        try {
            $ids = $this->pubMed->search($query, $limit);
            $xml = $this->pubMed->fetchDetails($ids);
            $normalizedItems = $this->normalizer->normalizePubMed($xml);

            $inserted = 0;
            $updated = 0;

            foreach ($normalizedItems as $data) {
                $article = ResearchArticle::updateOrCreate(
                    ['pmid' => $data['pmid']],
                    array_merge($data, ['status' => 'draft'])
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

            return $log;

        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'finished_at' => now(),
            ]);
            Log::error('PubMed Sync Job Failed', ['error' => $e->getMessage()]);
            return $log;
        }
    }

    /**
     * Run ingestion for ClinicalTrials.
     */
    public function syncTrials($query = 'Amyotrophic Lateral Sclerosis', $limit = 20)
    {
        $log = IngestionLog::create([
            'source_name' => 'ClinicalTrials.gov',
            'content_type' => 'trial',
            'status' => 'started',
            'started_at' => now(),
        ]);

        try {
            $studies = $this->trials->fetchTrials($query, $limit);
            
            $inserted = 0;
            $updated = 0;

            foreach ($studies as $study) {
                $data = $this->normalizer->normalizeTrial($study);
                
                $trial = ClinicalTrial::updateOrCreate(
                    ['nct_id' => $data['nct_id']],
                    array_merge($data, ['status' => 'draft'])
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

            return $log;

        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'finished_at' => now(),
            ]);
            Log::error('ClinicalTrials Sync Job Failed', ['error' => $e->getMessage()]);
            return $log;
        }
    }
}
