<?php

namespace App\Services\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DrugAdapter
{
    protected $baseUrl = 'https://api.fda.gov/drug/label.json';

    /**
     * Search for drugs related to ALS.
     */
    public function searchALS()
    {
        $response = Http::get($this->baseUrl, [
            'search' => 'indications_and_usage:"amyotrophic lateral sclerosis"',
            'limit' => 10,
        ]);

        if ($response->failed()) {
            Log::error('OpenFDA Search Failed', ['response' => $response->body()]);
            return [];
        }

        return $response->json()['results'] ?? [];
    }
}
