<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Standart haberleri çek
        $latestContents = \App\Models\Content::where('status', 'published')->latest()->take(6)->get();
        
        // Araştırmaları ayrı bir değişken olarak çek (Risk yok)
        $latestResearch = \App\Models\ResearchArticle::where('status', 'published')
            ->orderByRaw("COALESCE(
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.MedlineCitation.DateCompleted.Year')),
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.MedlineCitation.Article.ArticleDate.Year')),
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.MedlineCitation.Article.Journal.JournalIssue.PubDate.Year')),
                YEAR(created_at)
            ) DESC, created_at DESC")
            ->take(6)->get();

        // Klima Çalışmaları çek
        $latestTrials = \App\Models\ClinicalTrial::where('status', 'published')
            ->orderByRaw("COALESCE(
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.protocolSection.statusModule.lastUpdateSubmitDate')), 
                JSON_UNQUOTE(JSON_EXTRACT(raw_payload_json, '$.protocolSection.statusModule.studyFirstPostDateStruct.date')),
                created_at
            ) DESC")
            ->take(6)->get();

        // İlaç Gelişmelerini çek
        $latestDrugs = \App\Models\Drug::where('drugs.status', 'published')
            ->select('drugs.*')
            ->leftJoin('drug_regional_statuses', function($join) {
                 $join->on('drugs.id', '=', 'drug_regional_statuses.drug_id')
                      ->where('drug_regional_statuses.region', '=', 'US');
            })
            ->orderByRaw("COALESCE(
                JSON_UNQUOTE(JSON_EXTRACT(drug_regional_statuses.raw_payload_json, '$.effective_time')),
                drugs.created_at
            ) DESC")
            ->take(6)->get();

        // Klinik Rehberleri çek
        $latestGuidelines = \App\Models\Guideline::where('status', 'published')->latest()->take(4)->get();

        return view('frontend.home', compact('latestContents', 'latestResearch', 'latestTrials', 'latestDrugs', 'latestGuidelines'));
    }

    public function aboutAls()
    {
        return view('frontend.pages.about_als');
    }

    public function aboutUs()
    {
        return view('frontend.pages.about_us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function policy()
    {
        return view('frontend.pages.policy');
    }
}
