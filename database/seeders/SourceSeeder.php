<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Source;

class SourceSeeder extends Seeder
{
    public function run(): void
    {
        // Clinical Trials Source (PubMed filtered)
        Source::updateOrCreate(
            ['base_url' => 'https://pubmed.ncbi.nlm.nih.gov/rss/search/1Hce2XNQm0h6DOE6iLnRBeOB_PzR-LJVE6lP7oG4yvpBvqcspj/?limit=15&term=als+AND+clinical+trial'],
            [
                'name' => 'ALS Klinik Çalışmalar (PubMed)',
                'type' => 'trial',
                'fetch_method' => 'rss',
                'is_active' => true,
            ]
        );

        // Drug News Source (ALS News Today)
        Source::updateOrCreate(
            ['base_url' => 'https://alsnewstoday.com/tag/drug-development/feed/'],
            [
                'name' => 'ALS İlaç Gelişmeleri (ALS News Today)',
                'type' => 'drug',
                'fetch_method' => 'rss',
                'is_active' => true,
            ]
        );
    }
}
