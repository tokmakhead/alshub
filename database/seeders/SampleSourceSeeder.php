<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Source::create([
            'name' => 'PubMed ALS Research',
            'type' => 'publication',
            'base_url' => 'https://pubmed.ncbi.nlm.nih.gov/rss/search/1-wG_x_1-wG_x...', // Example RSS URL
            'fetch_method' => 'rss',
            'is_active' => true,
        ]);
    }
}
