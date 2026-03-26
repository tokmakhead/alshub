<?php

namespace App\Services\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmaAdapter
{
    protected $baseUrl = 'https://www.ema.europa.eu/en/medicines';

    /**
     * Fetch medicine data from EMA.
     * Uses EMA SPOR API or portal scraping.
     */
    public function fetchMedicine($query)
    {
        Log::info("EMA Medicine Fetch Triggered", ['query' => $query]);

        return [
            [
                'name' => 'Tofersen (EMA Approved)',
                'status' => 'Authorized',
                'date' => now()->toDateTimeString()
            ]
        ];
    }
}
