<?php

namespace App\Services;

use App\Models\Content;

class TranslationService
{
    /**
     * Placeholder translation logic.
     * In a real scenario, this would call an AI API like Gemini or DeepL.
     */
    public function translate(Content $content)
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            \Illuminate\Support\Facades\Log::error("Gemini API Key missing in .env");
            return $content;
        }

        try {
            $prompt = "Aşağıdaki ALS ile ilgili tıbbi haber başlığını ve özetini Türkçeye çevir ve özetle. Yanıtında sadece Türkçe başlık ve Türkçe özeti aralarında '|' işareti koyarak döndür. \n\nBaşlık: {$content->original_title}\nÖzet: {$content->original_summary}";

            $response = \Illuminate\Support\Facades\Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($text) {
                    $parts = explode('|', $text);
                    $content->translated_title = trim($parts[0]);
                    if (isset($parts[1])) {
                        $content->translated_summary = trim($parts[1]);
                    } else {
                        $content->translated_summary = trim($text);
                    }
                    $content->status = 'review';
                    $content->save();
                }
            } else {
                \Illuminate\Support\Facades\Log::error("Gemini API Error: " . $response->body());
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Translation Error: " . $e->getMessage());
        }

        return $content;
    }
}
