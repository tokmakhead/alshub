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
            $prompt = "Sen uzman bir tıp çevirmenisin. Aşağıdaki ALS ile ilgili bilimsel makalenin başlığını ve özetini (abstract) Türkçeye eksiksiz, profesyonel ve aslına sadık kalarak çevir. \n\n" .
                      "ÖNEMLİ KURALLAR:\n" .
                      "1. Özetleme YAPMA, her cümleyi çevir.\n" .
                      "2. Varsa 'Objective', 'Methods', 'Results', 'Conclusion' başlıklarını 'AMAÇ', 'YÖNTEM', 'BULGULAR', 'SONUÇ' olarak koru.\n" .
                      "3. Yanıtında SADECE çeviriyi şu formatta ver: [BASLIK]Çevrilmiş Başlık[OZET]Çevrilmiş Tam Metin\n\n" .
                      "BAŞLIK: {$content->original_title}\n" .
                      "ÖZET: {$content->original_summary}";

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
                    // Improved parsing using markers
                    if (preg_match('/\[BASLIK\](.*?)\[OZET\](.*)/s', $text, $matches)) {
                        $content->translated_title = trim($matches[1]);
                        $content->translated_summary = trim($matches[2]);
                    } else {
                        // Fallback to simpler split if markers fail
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
