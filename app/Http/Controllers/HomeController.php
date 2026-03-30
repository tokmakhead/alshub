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
        $latestGuidelines = \App\Models\Guideline::where('status', 'published')
            ->orderByDesc('publication_date')
            ->take(4)
            ->get();

        // İstatistikleri çek
        $stats = [
            'research' => \App\Models\ResearchArticle::count(),
            'trials' => \App\Models\ClinicalTrial::count(),
            'drugs' => \App\Models\Drug::count(),
            'guidelines' => \App\Models\Guideline::count(),
        ];

        return view('frontend.home', compact('latestContents', 'latestResearch', 'latestTrials', 'latestDrugs', 'latestGuidelines', 'stats'));
    }

    public function aboutAls()
    {
        return view('frontend.pages.about_als');
    }

    public function aboutUs()
    {
        $stats = [
            'research' => \App\Models\ResearchArticle::count(),
            'trials' => \App\Models\ClinicalTrial::count(),
            'drugs' => \App\Models\Drug::count(),
            'guidelines' => \App\Models\Guideline::count(),
        ];
        
        $trustedSources = \App\Models\SourceRegistry::where('is_enabled', true)
            ->where('source_name', 'not like', '%NY%')
            ->orderBy('verification_tier', 'desc')
            ->get();

        return view('frontend.pages.about_us', compact('stats', 'trustedSources'));
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:50',
            'message' => 'required|string|min:10',
        ]);

        try {
            // 1. Save to Database
            $contact = \App\Models\ContactMessage::create(array_merge($validated, [
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]));

            // 2. Trigger Telegram Notification
            $telegramMsg = "<b>📩 Yeni Mesaj (ALSHub)</b>\n\n"
                        . "<b>Kişi:</b> {$contact->name}\n"
                        . "<b>E-posta:</b> {$contact->email}\n"
                        . "<b>Konu:</b> {$contact->subject}\n"
                        . "<b>Tarih:</b> " . now()->format('d.m.Y H:i') . "\n\n"
                        . "<b>Mesaj:</b>\n" . $contact->message;

            \App\Services\TelegramService::sendMessage($telegramMsg);

            return response()->json([
                'success' => true,
                'message' => 'Mesajınız başarıyla iletildi. En kısa sürede dönüş yapacağız.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.'
            ], 500);
        }
    }

    public function policy()
    {
        return view('frontend.pages.policy');
    }
}
