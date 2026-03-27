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
        return "Sen kıdemli bir tıp profesörü ve ALS uzmanısın. Aşağıdaki tıp metnini analiz et.\n\n" .
               "BAŞLIK: {$title}\n" .
               "ABSTRACT: {$abstract}\n\n" .
               "ÖNEMLİ KURALLAR:\n" .
               "1. YANITININ TAMAMI TÜRKÇE OLMALIDIR. İngilizce başlık veya terim bırakma.\n" .
               "2. 'Technical Summary' yerine 'Doktor Özeti' başlığını kullan.\n" .
               "3. 'Key Takeaways' yerine 'Önemli Maddeler' başlığını kullan.\n" .
               "4. Tıbbi terimleri parantez içinde aslıyla bırakabilirsin (Örn: Sialorrhea (Aşırı Salya)).\n\n" .
               "SENDEN BEKLENENLER:\n" .
               "1. Başlığı Türkçeye çevir (title_tr).\n" .
               "2. Doktorlar için teknik bir analiz (summary_doctor).\n" .
               "3. Hastalar için çok sade bir anlatım (summary_patient).\n" .
               "4. En önemli 3 çıkarım (key_takeaways).\n\n" .
               "YANIT FORMATI (SADECE JSON):\n" .
               "{\n" .
               "  \"title_tr\": \"...\",\n" .
               "  \"summary_doctor\": \"...\",\n" .
               "  \"summary_patient\": \"...\",\n" .
               "  \"key_takeaways\": [\"...\", \"...\", \"...\"]\n" .
               "}\n" .
               "ASLA başka metin ekleme.";
    }

    protected function parseResponse($text)
    {
        if (preg_match('/\{.*\}/s', $text, $matches)) {
            return json_decode($matches[0], true);
        }
        return null;
    }
}
