<?php

namespace App\Services\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PubMedAdapter
{
    protected $baseUrl = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/';
    protected $db = 'pubmed';

    /**
     * Search for ALS related articles.
     */
    public function search($query = 'Amyotrophic Lateral Sclerosis', $maxResults = 20)
    {
        $response = Http::get($this->baseUrl . 'esearch.fcgi', [
            'db' => $this->db,
            'term' => $query,
            'retmax' => $maxResults,
            'retmode' => 'json',
            'usehistory' => 'y',
        ]);

        if ($response->failed()) {
            Log::error('PubMed Search Failed', ['response' => $response->body()]);
            return [];
        }

        return $response->json()['esearchresult']['idlist'] ?? [];
    }

    /**
     * Fetch full details for a list of PMIDs.
     */
    public function fetchDetails(array $ids)
    {
        if (empty($ids)) return [];

        $response = Http::get($this->baseUrl . 'efetch.fcgi', [
            'db' => $this->db,
            'id' => implode(',', $ids),
            'retmode' => 'xml', // PubMed efetch works better with XML for full details
        ]);

        if ($response->failed()) {
            Log::error('PubMed Fetch Details Failed', ['ids' => $ids]);
            return null;
        }

        return $response->body();
    }
}
