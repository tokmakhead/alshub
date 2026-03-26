<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SourceRegistry;

class SourceRegistrySeeder extends Seeder
{
    public function run(): void
    {
        // 1. RESEARCH / PubMed (API Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'PubMed'],
            [
                'source_mode' => 'api',
                'is_enabled' => true,
                'config_json' => [
                    'endpoint' => 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/',
                    'default_query' => 'Amyotrophic Lateral Sclerosis',
                    'verification_tier' => 1
                ],
                'notes' => 'Official NIH/NLM PubMed API via Entrez E-Utilities.'
            ]
        );

        // 2. CLINICAL TRIALS / ClinicalTrials.gov (API Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'ClinicalTrials.gov'],
            [
                'source_mode' => 'api',
                'is_enabled' => true,
                'config_json' => [
                    'endpoint' => 'https://clinicaltrials.gov/api/v2/',
                    'default_query' => 'Amyotrophic Lateral Sclerosis',
                    'verification_tier' => 1
                ],
                'notes' => 'Official ClinicalTrials.gov API v2.'
            ]
        );

        // 3. DRUGS / FDA (API Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'OpenFDA'],
            [
                'source_mode' => 'api',
                'is_enabled' => true,
                'config_json' => [
                    'endpoint' => 'https://api.fda.gov/drug/label.json',
                    'verification_tier' => 1
                ],
                'notes' => 'Official FDA drug labeling and approval status API.'
            ]
        );

        // 4. GUIDELINES / NICE-AAN-EAN (Manual/Curated)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'Guidelines (NICE/EAN)'],
            [
                'source_mode' => 'manual',
                'is_enabled' => true,
                'config_json' => [
                    'verification_tier' => 1
                ],
                'notes' => 'Manual entry for official clinical guidelines.'
            ]
        );
    }
}
