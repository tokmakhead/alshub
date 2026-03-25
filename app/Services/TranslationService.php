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
            // Strip HTML from original summary to provide a clean text to AI
            $cleanSummary = strip_tags($content->original_summary);
            
            $prompt = "Sen uzman bir tıp çevirmenisin. Aşağıdaki ALS makalesini Türkçeye çevir.\n\n" .
                      "KESİN KURALLAR:\n" .
                      "1. Yanıtını SADECE geçerli bir JSON formatında ver.\n" .
                      "2. JSON şeması: {\"baslik\": \"...\", \"ozet\": \"...\"}\n" .
                      "3. ASLA başka açıklama yapma.\n" .
                      "4. Özetleme yapma, tam metni çevir.\n\n" .
                      "BAŞLIK: {$content->original_title}\n" .
                      "ÖZET: {$cleanSummary}";

            $response = \Illuminate\Support\Facades\Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
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
                    // Try to extract JSON if AI adds markdown code blocks
                    if (preg_match('/\{.*\}/s', $text, $matches)) {
                        $jsonData = json_decode($matches[0], true);
                        if ($jsonData && isset($jsonData['baslik'], $jsonData['ozet'])) {
                            $content->translated_title = trim($jsonData['baslik']);
                            $content->translated_summary = trim($jsonData['ozet']);
                            $content->status = 'review';
                            $content->save();
                            return $content;
                        }
                    }

                    // Fallback to old regex just in case
                    if (preg_match('/\[BASLIK\]\s*(.*?)\s*\[OZET\]\s*(.*)/si', $text, $matches)) {
                        $content->translated_title = trim($matches[1]);
                        $content->translated_summary = trim($matches[2]);
                    } else {
                        // Extreme fallback
                        $content->translated_title = $content->original_title;
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
