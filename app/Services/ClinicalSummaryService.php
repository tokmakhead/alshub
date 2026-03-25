<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClinicalSummaryService
{
    protected $apiKey;
    protected $baseUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Generate multi-layered summary for scientific content.
     */
    public function summarize($title, $abstract, $type = 'research')
    {
        if (!$this->apiKey) {
            return ['error' => 'API Key missing'];
        }

        $prompt = $this->buildPrompt($title, $abstract, $type);

        try {
            $response = Http::post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            if ($response->successful()) {
                $text = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) {
                    return $this->parseResponse($text);
                }
            }
            
            Log::error("Gemini API Error: " . $response->body());
        } catch (\Exception $e) {
            Log::error("ClinicalSummary Error: " . $e->getMessage());
        }

        return null;
    }

    protected function buildPrompt($title, $abstract, $type)
    {
        return "Sen uzman bir tıp editörü ve ALS araştırmacısısın. Aşağıdaki {$type} verisini analiz et.\n\n" .
               "BAŞLIK: {$title}\n" .
               "ABSTRACT: {$abstract}\n\n" .
               "SENDEN BEKLENENLER:\n" .
               "1. Başlığı Türkçeye çevir.\n" .
               "2. Doktorlar için teknik bir özet (Technical Summary) hazırla.\n" .
               "3. Hastalar ve aileleri için tıbbi terimlerden arındırılmış, umut verici ama gerçekçi bir anlatım (Patient Friendly) hazırla.\n" .
               "4. Bu çalışmadan çıkarılacak en önemli 3 maddeyi (Key Takeaways) belirle.\n\n" .
               "YANIT FORMATI (SADECE JSON):\n" .
               "{\n" .
               "  \"title_tr\": \"...\",\n" .
               "  \"summary_doctor\": \"...\",\n" .
               "  \"summary_patient\": \"...\",\n" .
               "  \"key_takeaways\": [\"...\", \"...\", \"...\"]\n" .
               "}\n" .
               "ASLA başka metin ekleme, sadece JSON döndür.";
    }

    protected function parseResponse($text)
    {
        if (preg_match('/\{.*\}/s', $text, $matches)) {
            return json_decode($matches[0], true);
        }
        return null;
    }
}
