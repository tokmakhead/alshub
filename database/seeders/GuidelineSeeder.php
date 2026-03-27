<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guideline;

class GuidelineSeeder extends Seeder
{
    public function run()
    {
        $guidelines = [
            [
                'source_org' => 'AAN (American Academy of Neurology)',
                'title' => 'Practice Parameter: Drug Therapy and Symptom Management in ALS',
                'summary_original' => 'Evidence-based review of drug therapies (Riluzole) and management of symptoms (Sialorrhea, pseudobulbar affect, cramps) in patients with ALS.',
                'source_url' => 'https://www.aan.com/Guidelines/home/GetGuidelineContent/372',
                'verification_tier' => 1,
                'status' => 'published'
            ],
            [
                'source_org' => 'AAN (American Academy of Neurology)',
                'title' => 'Practice Parameter: Nutrition and Respiratory Support in ALS',
                'summary_original' => 'Guidelines on the timing of PEG placement for nutrition and the use of Noninvasive Ventilation (NIV) to extend life and quality.',
                'source_url' => 'https://www.aan.com/Guidelines/home/GetGuidelineContent/373',
                'verification_tier' => 1,
                'status' => 'published'
            ],
            [
                'source_org' => 'NICE (UK)',
                'title' => 'Motor neurone disease: assessment and management (NG42)',
                'summary_original' => 'Comprehensive UK guidelines covering multidisciplinary care, symptom management, and end-of-life care for MND patients.',
                'source_url' => 'https://www.nice.org.uk/guidance/ng42',
                'verification_tier' => 1,
                'status' => 'published'
            ],
            [
                'source_org' => 'EFNS (European)',
                'title' => 'EFNS guidelines on the Clinical Management of ALS',
                'summary_original' => 'European consensus on the diagnosis and management of ALS, including genetic testing and symptomatic treatments.',
                'source_url' => 'https://onlinelibrary.wiley.com/doi/abs/10.1111/j.1468-1331.2012.03691.x',
                'verification_tier' => 1,
                'status' => 'published'
            ],
            [
                'source_org' => 'ALS Association (USA)',
                'title' => 'Respiratory Care and Breathing Support in ALS',
                'summary_original' => 'Patient-centric guide on identifying breathing changes, using NIV, and clearing secretions.',
                'source_url' => 'https://www.als.org/library/breathing-trouble-and-als',
                'verification_tier' => 2,
                'status' => 'published'
            ],
            [
                'source_org' => 'ALS Association (USA)',
                'title' => 'Nutritional Care and Feeding Tubes (PEG) in ALS',
                'summary_original' => 'Practical advice on managing swallowing difficulties, calorie intake, and the benefits of PEG placement.',
                'source_url' => 'https://www.als.org/library/nutrition-and-als',
                'verification_tier' => 2,
                'status' => 'published'
            ],
            [
                'source_org' => 'MND Association (UK)',
                'title' => 'PEG and RIG: Information for Professionals',
                'summary_original' => 'Detailed clinical protocol for gastrostomy placement and post-procedure care for motor neurone disease.',
                'source_url' => 'https://www.mndassociation.org/professionals/management-of-mnd/respiratory-and-nutritional-management/',
                'verification_tier' => 2,
                'status' => 'published'
            ],
            [
                'source_org' => 'WFN (World Federation of Neurology)',
                'title' => 'Revised El Escorial Criteria for the Diagnosis of ALS',
                'summary_original' => 'The international standard for classifying ALS diagnosis certainty (Definite, Probable, Possible).',
                'source_url' => 'https://www.wfnals.org/guidelines/el-escorial-criteria',
                'verification_tier' => 1,
                'status' => 'published'
            ],
            [
                'source_org' => 'ALS/MND World Federation',
                'title' => 'Gold Coast Criteria for the Diagnosis of ALS (2020 Update)',
                'summary_original' => 'Simplified diagnostic criteria aiming to accelerate clinical trial participation and diagnosis for patients.',
                'source_url' => 'https://www.clinicalneurophysiology.org/article/S1388-2457(20)30386-X/fulltext',
                'verification_tier' => 1,
                'status' => 'published'
            ],
            [
                'source_org' => 'ALS Association (USA)',
                'title' => 'Exercise and Physical Therapy in ALS',
                'summary_original' => 'Guidelines on maintaining mobility, range of motion, and preventing complications through safe exercise.',
                'source_url' => 'https://www.als.org/library/exercise-and-als',
                'verification_tier' => 2,
                'status' => 'published'
            ]
        ];

        foreach ($guidelines as $item) {
            Guideline::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
