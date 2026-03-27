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
            // Prefer original_content if it's longer than summary (for full articles)
            $sourceText = $content->original_content && strlen($content->original_content) > strlen($content->original_summary) 
                ? $content->original_content 
                : $content->original_summary;

            // Strip HTML but keep some context, limit to 4000 chars for Gemini
            $cleanSource = \Illuminate\Support\Str::limit(strip_tags($sourceText), 4000);
            
            $prompt = "Sen uzman bir tıp çevirmenisin. Aşağıdaki ALS makalesini Türkçeye çevir.\n\n" .
                      "KESİN KURALLAR:\n" .
                      "1. Yanıtını SADECE geçerli bir JSON formatında ver.\n" .
                      "2. JSON şeması: {\"baslik\": \"...\", \"ozet\": \"...\"}\n" .
                      "3. ASLA başka açıklama yapma.\n" .
                      "4. Özetleme yapma, tam metni çevir.\n\n" .
                      "BAŞLIK: {$content->original_title}\n" .
                      "METİN: {$cleanSource}";

            $response = \Illuminate\Support\Facades\Http::timeout(60)
                ->retry(2, 2000)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2, // Faster and more consistent
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 2048,
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
