<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\ExpertCenter;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        $doctors = [
            // USA / MGH
            [
                'center_name' => 'Massachusetts General Hospital ALS House',
                'first_name' => 'Merit',
                'last_name' => 'Cudkowicz',
                'title' => 'Prof. Dr.',
                'specialty' => 'Neurology / ALS Research',
                'biography' => 'Chief of Neurology at MGH and co-founder of NEALS.',
                'is_verified' => true
            ],
            // Netherlands / UMC Utrecht
            [
                'center_name' => 'Utrecht University Medical Center (UMC Utrecht)',
                'first_name' => 'Leonard',
                'last_name' => 'van den Berg',
                'title' => 'Prof. Dr.',
                'specialty' => 'Genetic Neurology',
                'biography' => 'Director of the Netherlands ALS Center and ENCALS chair.',
                'is_verified' => true
            ],
            // UK / King's College
            [
                'center_name' => 'King\'s College London ALS Center',
                'first_name' => 'Ammar',
                'last_name' => 'Al-Chalabi',
                'title' => 'Prof. Dr.',
                'specialty' => 'Medical Statistics and Epidemiology',
                'biography' => 'Leading researcher in ALS genetics and epidemiology.',
                'is_verified' => true
            ],
            // Germany / Charité
            [
                'center_name' => 'Charité - Universitätsmedizin Berlin',
                'first_name' => 'Thomas',
                'last_name' => 'Meyer',
                'title' => 'Prof. Dr.',
                'specialty' => 'Neurology',
                'biography' => 'Head of the ALS Outpatient Clinic at Charité Berlin.',
                'is_verified' => true
            ],

            // Turkey / İstanbul Tıp (Çapa)
            [
                'center_name' => 'I.Ü. İstanbul Tıp Fakültesi (Çapa) Nöroloji',
                'first_name' => 'Piraye',
                'last_name' => 'Serdaroğlu',
                'title' => 'Prof. Dr.',
                'specialty' => 'Nöromüsküler Hastalıklar',
                'biography' => 'Türkiye\'nin en deneyimli nöromüsküler hastalık uzmanlarından biri.',
                'is_verified' => true
            ],
            [
                'center_name' => 'I.Ü. İstanbul Tıp Fakültesi (Çapa) Nöroloji',
                'first_name' => 'Halil Atilla',
                'last_name' => 'İdrisoğlu',
                'title' => 'Prof. Dr.',
                'specialty' => 'Nöroloji / ALS Uzmanı',
                'biography' => 'ALS Derneği Türkiye kurucularından ve uzun süreli başkanı.',
                'is_verified' => true
            ],
            [
                'center_name' => 'I.Ü. İstanbul Tıp Fakültesi (Çapa) Nöroloji',
                'first_name' => 'Yeşim',
                'last_name' => 'Parman',
                'title' => 'Prof. Dr.',
                'specialty' => 'Nöroloji / Nörolojik Bilimler',
                'biography' => 'Periferik sinir hastalıkları ve ALS konusunda uzman otorite.',
                'is_verified' => true
            ],

            // Turkey / Hacettepe
            [
                'center_name' => 'Hacettepe Üniversitesi Nöroloji AD',
                'first_name' => 'Ersin',
                'last_name' => 'Tan',
                'title' => 'Prof. Dr.',
                'specialty' => 'Nöromüsküler Hastalıklar / ALS',
                'biography' => 'Hacettepe Üniversitesi Nöroloji AD emekli öğretim üyesi ve Türkiye\'nin en kıdemli ALS otoritelerinden biri.',
                'is_verified' => true
            ],
            [
                'center_name' => 'Hacettepe Üniversitesi Nöroloji AD',
                'first_name' => 'Sevim',
                'last_name' => 'Erdem Özdamar',
                'title' => 'Prof. Dr.',
                'specialty' => 'Nöromüsküler Hastalıklar',
                'biography' => 'Hacettepe Üniversitesi ALS polikliniği sorumlusu.',
                'is_verified' => true
            ],

            // USA / Johns Hopkins
            [
                'center_name' => 'Johns Hopkins ALS Clinic',
                'first_name' => 'Jeffrey',
                'last_name' => 'Rothstein',
                'title' => 'Prof. Dr. PhD',
                'specialty' => 'Neurology and Neuroscience',
                'biography' => 'Director of the Robert Packard Center for ALS Research.',
                'is_verified' => true
            ]
        ];

        foreach ($doctors as $doc) {
            $center = ExpertCenter::where('name', $doc['center_name'])->first();
            
            if ($center) {
                Doctor::updateOrCreate(
                    [
                        'first_name' => $doc['first_name'], 
                        'last_name' => $doc['last_name']
                    ],
                    [
                        'expert_center_id' => $center->id,
                        'title' => $doc['title'],
                        'specialty' => $doc['specialty'],
                        'biography' => $doc['biography'],
                        'is_verified' => $doc['is_verified']
                    ]
                );
            }
        }
    }
}
