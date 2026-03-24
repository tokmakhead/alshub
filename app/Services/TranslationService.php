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
        if ($content->translated_title && $content->translated_summary) {
            return $content;
        }

        // Dummy TR translation
        $content->translated_title = "[TR] " . $content->original_title;
        $content->translated_summary = "Bu içerik henüz Türkçe'ye çevrilmemiştir. Orijinal özet: " . $content->original_summary;
        $content->status = 'review'; // Move to review after "translation"
        $content->save();

        return $content;
    }
}
