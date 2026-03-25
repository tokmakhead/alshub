<?php

namespace App\Services\Normalizers;

use App\Models\ResearchArticle;
use App\Models\ClinicalTrial;
use Illuminate\Support\Str;

class ContentNormalizer
{
    /**
     * Normalize PubMed XML to ResearchArticle data array.
     */
    public function normalizePubMed($xmlString)
    {
        $xml = simplexml_load_string($xmlString);
        if (!$xml) return [];

        $articles = [];
        foreach ($xml->PubmedArticle as $item) {
            $medline = $item->MedlineCitation;
            $article = $medline->Article;
            
            $pmid = (string) $medline->PMID;
            
            $doiArr = $item->xpath('PubmedData/ArticleIdList/ArticleId[@IdType="doi"]');
            $doi = (count($doiArr) > 0) ? (string) $doiArr[0] : null;
            
            $articles[] = [
                'pmid' => $pmid,
                'doi' => $doi,
                'title' => (string) $article->ArticleTitle,
                'abstract_original' => (string) $article->Abstract->AbstractText,
                'journal' => (string) $article->Journal->Title,
                'publication_date' => $this->parsePubMedDate($article->Journal->JournalIssue->PubDate),
                'authors_json' => $this->parsePubMedAuthors($article->AuthorList),
                'source_url' => "https://pubmed.ncbi.nlm.nih.gov/{$pmid}/",
                'raw_payload_json' => json_decode(json_encode($item), true),
            ];
        }

        return $articles;
    }

    /**
     * Normalize ClinicalTrials.gov JSON to ClinicalTrial data array.
     */
    public function normalizeTrial($rawData)
    {
        $protocol = $rawData['protocolSection'] ?? [];
        
        return [
            'nct_id' => $protocol['identificationModule']['nctId'] ?? null,
            'title' => $protocol['identificationModule']['briefTitle'] ?? null,
            'summary' => $protocol['descriptionModule']['briefSummary'] ?? null,
            'phase' => implode(', ', $protocol['designModule']['phases'] ?? []),
            'recruitment_status' => $protocol['statusModule']['overallStatus'] ?? null,
            'sponsor' => $protocol['sponsorCollaboratorsModule']['leadSponsor']['name'] ?? null,
            'intervention' => $this->formatInterventions($protocol['armsInterventionsModule']['interventions'] ?? []),
            'countries_json' => $protocol['contactsLocationsModule']['locations'] ?? [],
            'source_url' => "https://clinicaltrials.gov/ct2/show/" . ($protocol['identificationModule']['nctId'] ?? ''),
            'raw_payload_json' => $rawData,
        ];
    }

    /**
     * Normalize OpenFDA drug JSON to Drug and Regional Status data.
     */
    public function normalizeDrug($rawData)
    {
        $openfda = $rawData['openfda'] ?? [];
        
        return [
            'generic_name' => $openfda['generic_name'][0] ?? (string) \Illuminate\Support\Str::limit($rawData['indications_and_usage'][0] ?? 'Unknown Drug', 100),
            'brand_name' => $openfda['brand_name'][0] ?? null,
            'slug' => \Illuminate\Support\Str::slug($openfda['generic_name'][0] ?? \Illuminate\Support\Str::random(10)),
            'region_status' => [
                'region' => 'US',
                'regulator_name' => 'FDA',
                'external_id' => $rawData['id'] ?? null,
                'indication' => $rawData['indications_and_usage'][0] ?? null,
                'approval_status' => 'Approved',
                'label_url' => "https://labels.fda.gov/preview.cfm?id=" . ($rawData['id'] ?? ''),
                'raw_payload_json' => $rawData,
            ]
        ];
    }

    private function parsePubMedDate($pubDate)
    {
        $year = (string) $pubDate->Year ?? date('Y');
        $month = (string) $pubDate->Month ?? '01';
        $day = (string) $pubDate->Day ?? '01';
        
        try {
            return \Carbon\Carbon::parse("$year-$month-$day");
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parsePubMedAuthors($authorList)
    {
        if (!$authorList) return [];
        $authors = [];
        foreach ($authorList->Author as $author) {
            $authors[] = (string) $author->LastName . ' ' . (string) $author->ForeName;
        }
        return $authors;
    }

    private function formatInterventions($interventions)
    {
        if (empty($interventions)) return null;
        return implode('; ', array_map(fn($i) => ($i['type'] ?? '') . ': ' . ($i['name'] ?? ''), $interventions));
    }
}
