<?php

namespace App\Http\Controllers;

use App\Models\ResearchArticle;
use App\Models\ClinicalTrial;
use App\Models\Drug;
use App\Models\Guideline;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function publications()
    {
        // Yıla göre ve created_at'e göre kaba SQL sıralaması (Performans için)
        // PubMed XML yapıları karışık olduğu için en net 'Year' düğümlerinden birini referans alır.
        $contents = ResearchArticle::where('status', 'published')
            ->orderByRaw("COALESCE(
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.MedlineCitation.DateCompleted.Year')),
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.MedlineCitation.Article.ArticleDate.Year')),
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.MedlineCitation.Article.Journal.JournalIssue.PubDate.Year')),
                YEAR(created_at)
            ) DESC, created_at DESC")
            ->paginate(12);
            
        $title = "Bilimsel Araştırmalar";
        return view('frontend.content.index', compact('contents', 'title'));
    }

    public function trials()
    {
        $contents = ClinicalTrial::where('status', 'published')
            ->orderByRaw("COALESCE(
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.protocolSection.statusModule.lastUpdateSubmitDate')), 
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.protocolSection.statusModule.studyFirstPostDateStruct.date')),
                created_at
            ) DESC")
            ->paginate(12);
            
        $title = "Klinik Çalışmalar";
        return view('frontend.content.index', compact('contents', 'title'));
    }

    public function drugs()
    {
        $contents = Drug::where('drugs.status', 'published')
            ->select('drugs.*')
            ->leftJoin('drug_regional_statuses', function($join) {
                 $join->on('drugs.id', '=', 'drug_regional_statuses.drug_id')
                      ->where('drug_regional_statuses.region', '=', 'US');
            })
            ->orderByRaw("COALESCE(
                JSON_UNQUOTE(JSON_EXTRACT(drug_regional_statuses.raw_payload_json, '$.effective_time')),
                drugs.created_at
            ) DESC")
            ->paginate(12);
            
        $title = "İlaç ve Tedavi Gelişmeleri";
        return view('frontend.content.index', compact('contents', 'title'));
    }

    public function guidelines()
    {
        $contents = Guideline::where('status', 'published')->latest()->paginate(12);
        $title = "Klinik Rehberler";
        return view('frontend.content.index', compact('contents', 'title'));
    }

    public function show($type, $slug)
    {
        $model = match($type) {
            'research' => ResearchArticle::class,
            'trial' => ClinicalTrial::class,
            'drug' => Drug::class,
            'guideline' => Guideline::class,
            default => Content::class
        };

        $content = $model::where('slug', $slug)->firstOrFail();
        return view('frontend.content.show', compact('content'));
    }

    public function search(Request $request)
    {
        $term = $request->input('q');
        // Simple search on ResearchArticles for now, can be expanded to polymorphic search
        $contents = ResearchArticle::where('status', 'published')
            ->where(function($query) use ($term) {
                $query->where('title', 'like', "%{$term}%")
                      ->orWhere('abstract_tr', 'like', "%{$term}%");
            })
            ->latest()
            ->paginate(12);
        
        $title = "'{$term}' için Arama Sonuçları";
        return view('frontend.content.index', compact('contents', 'title'));
    }
}
