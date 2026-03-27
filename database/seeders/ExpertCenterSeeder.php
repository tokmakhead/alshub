<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpertCenter;

class ExpertCenterSeeder extends Seeder
{
    public function run()
    {
        $centers = [
            // North America (NEALS / ALS Association)
            [
                'name' => 'Massachusetts General Hospital ALS House',
                'location_city' => 'Boston',
                'location_country' => 'USA',
                'website_url' => 'https://www.massgeneral.org/neurology/als',
                'description' => 'A leading NEALS member and clinical trial center.',
                'is_verified' => true
            ],
            [
                'name' => 'Mayo Clinic ALS Center',
                'location_city' => 'Rochester',
                'location_country' => 'USA',
                'website_url' => 'https://www.mayoclinic.org/diseases-conditions/amyotrophic-lateral-sclerosis/care-at-mayo-clinic/mac-20354030',
                'description' => 'Multi-disciplinary care and innovative research center.',
                'is_verified' => true
            ],
            [
                'name' => 'Johns Hopkins ALS Clinic',
                'location_city' => 'Baltimore',
                'location_country' => 'USA',
                'website_url' => 'https://www.hopkinsmedicine.org/neurology_neurosurgery/centers_clinics/als/',
                'description' => 'World-renowned for neurodegenerative research.',
                'is_verified' => true
            ],
            [
                'name' => 'Cedars-Sinai ALS Program',
                'location_city' => 'Los Angeles',
                'location_country' => 'USA',
                'website_url' => 'https://www.cedars-sinai.org/programs/neurology-neurosurgery/clinical/als.html',
                'description' => 'Certified treatment center of excellence.',
                'is_verified' => true
            ],
            
            // Europe (ENCALS)
            [
                'name' => 'Charité - Universitätsmedizin Berlin',
                'location_city' => 'Berlin',
                'location_country' => 'Germany',
                'website_url' => 'https://als-charite.de/',
                'description' => 'Largest ALS research and treatment center in Germany.',
                'is_verified' => true
            ],
            [
                'name' => 'Utrecht University Medical Center (UMC Utrecht)',
                'location_city' => 'Utrecht',
                'location_country' => 'Netherlands',
                'website_url' => 'https://www.umcutrecht.nl/en/als-center',
                'description' => 'Leading ENCALS coordinator and genetic research hub.',
                'is_verified' => true
            ],
            [
                'name' => 'King\'s College London ALS Center',
                'location_city' => 'London',
                'location_country' => 'UK',
                'website_url' => 'https://www.kcl.ac.uk/research/mnd-care-and-research-centre',
                'description' => 'Pioneer in ALS gene identification and care standards.',
                'is_verified' => true
            ],
            [
                'name' => 'Hôpital de la Pitié-Salpêtrière',
                'location_city' => 'Paris',
                'location_country' => 'France',
                'website_url' => 'https://www.aphp.fr/',
                'description' => 'Historic neurology center with dedicated ALS unit.',
                'is_verified' => true
            ],
            
            // Turkey (Local)
            [
                'name' => 'I.Ü. İstanbul Tıp Fakültesi (Çapa) Nöroloji',
                'location_city' => 'İstanbul',
                'location_country' => 'Turkey',
                'website_url' => 'https://istanbultip.istanbul.edu.tr/',
                'description' => 'Türkiye\'nin öncü ALS ve nöromüsküler hastalıklar merkezi.',
                'is_verified' => true
            ],
            [
                'name' => 'Hacettepe Üniversitesi Nöroloji AD',
                'location_city' => 'Ankara',
                'location_country' => 'Turkey',
                'website_url' => 'https://hastaneler.hacettepe.edu.tr/',
                'description' => 'Ankara\'da ALS tanı ve takibi konusunda uzman referans merkezi.',
                'is_verified' => true
            ],
            [
                'name' => 'Koç Üniversitesi Hastanesi ALS Grubu',
                'location_city' => 'İstanbul',
                'location_country' => 'Turkey',
                'website_url' => 'https://www.kuh.ku.edu.tr/',
                'description' => 'Modern araştırma imkanları sunan multidisipliner ALS kliniği.',
                'is_verified' => true
            ],
            [
                'name' => 'Ege Üniversitesi Nöroloji Kliniği',
                'location_city' => 'İzmir',
                'location_country' => 'Turkey',
                'website_url' => 'https://hastane.ege.edu.tr/',
                'description' => 'Ege bölgesinin ana ALS takip ve araştırma merkezi.',
                'is_verified' => true
            ],

            // Other International
            [
                'name' => 'Northwestern University ALS Center',
                'location_city' => 'Chicago',
                'location_country' => 'USA',
                'website_url' => 'https://www.nm.org/conditions-and-care-areas/neurosciences/als-program',
                'description' => 'Home to pioneering upper motor neuron research by Dr. Hande Ozdinler.',
                'is_verified' => true
            ],
            [
                'name' => 'University of Michigan ALS Center',
                'location_city' => 'Ann Arbor',
                'location_country' => 'USA',
                'website_url' => 'https://www.uofmhealth.org/conditions-treatments/brain-neurological-conditions/als',
                'description' => 'Leading center for stem cell therapy and environmental ALS research.',
                'is_verified' => true
            ],
            [
                'name' => 'Boğaziçi Üniversitesi NDAL Laboratuvarı',
                'location_city' => 'İstanbul',
                'location_country' => 'Turkey',
                'website_url' => 'https://ndal.ku.edu.tr/',
                'description' => 'Türkiye\'nin nörogenetik alanındaki en prestijli araştırma merkezi.',
                'is_verified' => true
            ],
            [
                'name' => 'Çukurova Üniversitesi Nöroloji AD',
                'location_city' => 'Adana',
                'location_country' => 'Turkey',
                'website_url' => 'https://cukurova.edu.tr/',
                'description' => 'Güney Türkiye\'nin ana ALS ve nöromüsküler hastalıklar merkezi.',
                'is_verified' => true
            ],
            [
                'name' => 'The University of Queensland ALS Research',
                'location_city' => 'Brisbane',
                'location_country' => 'Australia',
                'website_url' => 'https://qbi.uq.edu.au/als',
                'description' => 'Leading Australian center for motor neuron disease.',
                'is_verified' => true
            ],
            [
                'name' => 'Sun Yat-sen University ALS Clinic',
                'location_city' => 'Guangzhou',
                'location_country' => 'China',
                'website_url' => 'https://www.sysu.edu.cn/',
                'description' => 'Major ALS genetic and clinical research hub in Asia.',
                'is_verified' => true
            ]
        ];

        foreach ($centers as $center) {
            ExpertCenter::updateOrCreate(
                ['name' => $center['name']],
                $center
            );
        }
    }
}
