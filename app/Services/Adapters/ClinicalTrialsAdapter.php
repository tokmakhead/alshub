<?php

namespace App\Services\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClinicalTrialsAdapter
{
    protected $baseUrl = 'https://clinicaltrials.gov/api/v2/studies';

    /**
     * Fetch ALS related trials.
     */
    public function fetchTrials($query = 'Amyotrophic Lateral Sclerosis', $pageSize = 20)
    {
        $response = Http::get($this->baseUrl, [
            'query.cond' => $query,
            'pageSize' => $pageSize,
        ]);

        if ($response->failed()) {
            Log::error('ClinicalTrials Fetch Failed', ['response' => $response->body()]);
            return [];
        }

        return $response->json()['studies'] ?? [];
    }
}
