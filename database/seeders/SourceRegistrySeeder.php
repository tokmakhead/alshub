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
            ['source_name' => 'NICE Guidelines'],
            [
                'source_mode' => 'manual',
                'is_enabled' => true,
                'verification_tier' => 1,
                'official_url' => 'https://www.nice.org.uk/guidance/ng42',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/NICE_Logo.svg/1024px-NICE_Logo.svg.png',
                'notes' => 'National Institute for Health and Care Excellence (UK) official ALS guidelines.'
            ]
        );

        SourceRegistry::updateOrCreate(
            ['source_name' => 'EAN Guidelines'],
            [
                'source_mode' => 'manual',
                'is_enabled' => true,
                'verification_tier' => 1,
                'official_url' => 'https://www.ean.org',
                'logo_url' => 'https://ern-euro-nmd.eu/wp-content/uploads/2018/12/ean-logo.png',
                'notes' => 'European Academy of Neurology official ALS management guidelines.'
            ]
        );

        // 5. CLINICAL TRIALS / WHO ICTRP (API Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'WHO ICTRP'],
            [
                'source_mode' => 'api',
                'verification_tier' => 1,
                'is_enabled' => true,
                'config_json' => [
                    'endpoint' => 'https://apps.who.int/trialsearch/'
                ],
                'notes' => 'World Health Organization International Clinical Trials Registry Platform.'
            ]
        );

        // 6. REGULATORY / EMA (API Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'EMA'],
            [
                'source_mode' => 'api',
                'verification_tier' => 1,
                'is_enabled' => true,
                'config_json' => [
                    'endpoint' => 'https://www.ema.europa.eu/en/medicines'
                ],
                'notes' => 'European Medicines Agency official medicine data.'
            ]
        );

        // 7. NETWORK / NEALS (Web Ingest Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'NEALS'],
            [
                'source_mode' => 'web_ingest',
                'verification_tier' => 2,
                'is_enabled' => true,
                'config_json' => [
                    'url' => 'https://neals.org/als-clinics/find-a-clinic/'
                ],
                'notes' => 'Northeast ALS Consortium clinic network.'
            ]
        );

        // 8. NETWORK / ENCALS (Web Ingest Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'ENCALS'],
            [
                'source_mode' => 'web_ingest',
                'verification_tier' => 2,
                'is_enabled' => true,
                'config_json' => [
                    'url' => 'https://www.encals.eu/centres/'
                ],
                'notes' => 'European Network to Cure ALS centres.'
            ]
        );

        // 9. NETWORK / ALS Association (Web Ingest Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'ALS Association'],
            [
                'source_mode' => 'web_ingest',
                'verification_tier' => 2,
                'is_enabled' => true,
                'config_json' => [
                    'url' => 'https://www.als.org/local-support/certified-centers-clinics'
                ],
                'notes' => 'ALS Association Certified Treatment Centers of Excellence.'
            ]
        );

        // 10. NETWORK / MDA Care Center Network (Web Ingest Mode)
        SourceRegistry::updateOrCreate(
            ['source_name' => 'MDA Care Center Network'],
            [
                'source_mode' => 'web_ingest',
                'verification_tier' => 2,
                'is_enabled' => true,
                'config_json' => [
                    'url' => 'https://www.mda.org/care/care-center-network'
                ],
                'notes' => 'Muscular Dystrophy Association specialized ALS care centers.'
            ]
        );
    }
}
