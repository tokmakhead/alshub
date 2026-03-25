<?php

namespace App\Services;

use App\Models\Source;
use App\Models\Content;
use App\Models\ImportLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ContentFetcherService
{
    public function fetchFromSource(Source $source)
    {
        set_time_limit(0);
        ignore_user_abort(true);
        
        \Log::info("Fetch started for Source {$source->id} ({$source->name})");
        
        $source->update([
            'is_importing' => true,
            'import_progress' => 5,
            'import_message' => 'Bağlantı kuruluyor...',
        ]);
        try {
            \Log::info("Fetching RSS from: " . $source->base_url);
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept' => 'application/rss+xml, application/xml;q=0.9, */*;q=0.8',
            ])->timeout(30)->get($source->base_url);

            if (!$response->successful()) {
                $source->update(['is_importing' => false, 'import_message' => 'Hata: RSS çekilemedi.']);
                \Illuminate\Support\Facades\Log::error("Import Error for Source {$source->id}: Could not fetch RSS. HTTP Status: " . $response->status());
                return;
            }

            $rss = simplexml_load_string($response->body());
            $items = $rss->channel->item;
            $count = count($items);
            
            $source->update([
                'import_progress' => 10,
                'import_message' => "{$count} adet potansiyel içerik bulundu. İşleniyor...",
            ]);

            $importedCount = 0;
            $i = 0;
            foreach ($items as $item) {
                $i++;
                $source_url = (string) $item->link;
                $external_id = md5($source_url);

                \Log::info("Processing item {$i}/{$count}: " . $source_url);

                // Check if already exists
                if (Content::where('external_id', $external_id)->exists()) {
                    \Log::info("Item exists, skipping: " . $source_url);
                    continue;
                }

                $source->update([
                    'import_progress' => 10 + round(($i / $count) * 80),
                    'import_message' => "İşleniyor ({$i}/{$count}): " . Str::limit((string)$item->title, 30),
                ]);
                $original_summary = (string) $item->description;

                // Try to fetch full content from the link based on source type
                try {
                    $pageResponse = \Illuminate\Support\Facades\Http::withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                    ])->timeout(15)->get($source_url);

                    if ($pageResponse->successful() && class_exists('DOMDocument')) {
                        $html = $pageResponse->body();
                        $doc = new \DOMDocument();
                        @$doc->loadHTML('<?xml encoding="UTF-8">' . $html);
                        $xpath = new \DOMXPath($doc);
                        $fullText = "";

                        if (str_contains($source->base_url, 'pubmed')) {
                            $nodes = $xpath->query('//div[contains(@class, "abstract-content")]/p');
                        } elseif (str_contains($source->base_url, 'alsnewstoday.com')) {
                            // Target .pf-content and exclude ads/related blocks
                            $nodes = $xpath->query('//div[contains(@class, "pf-content")]/*[not(self::div[contains(@class, "code-block")]) and not(self::div[contains(@class, "bio-post-preview-inline")]) and not(self::div[contains(@class, "printfriendly")])]');
                        } else {
                            $nodes = null;
                        }

                        if ($nodes && $nodes->length > 0) {
                            foreach ($nodes as $node) {
                                $text = trim($node->textContent);
                                if (!empty($text)) {
                                    $fullText .= $text . "\n\n";
                                }
                            }
                            if (!empty(trim($fullText))) {
                                $original_summary = trim($fullText);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Could not scrape full content for {$source_url}: " . $e->getMessage());
                }

                $content = Content::create([
                    'type' => $source->type,
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                    'source_url' => $source_url,
                    'original_title' => (string) $item->title,
                    'original_summary' => $original_summary,
                    'external_id' => $external_id,
                    'language' => 'en',
                    'status' => 'draft',
                    'source_published_at' => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
                    'slug' => Str::slug((string) $item->title) . '-' . Str::random(5),
                ]);
                $importedCount++;

                // Trigger AI translation immediately
                try {
                    $translationService = app(\App\Services\TranslationService::class);
                    $translationService->translate($content);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Auto-translation failed for content {$content->id}: " . $e->getMessage());
                }
            }

            ImportLog::create([
                'source_id' => $source->id,
                'status' => 'success',
                'message' => "Successfully imported {$count} items.",
            ]);

            $source->update([
                'is_importing' => false,
                'import_progress' => 100,
                'import_message' => "Tamamlandı: {$importedCount} yeni içerik.",
            ]);

            return true;

        } catch (\Exception $e) {
            $source->update([
                'is_importing' => false,
                'import_message' => 'Hata: ' . Str::limit($e->getMessage(), 50),
            ]);

            ImportLog::create([
                'source_id' => $source->id,
                'status' => 'failure',
                'message' => $e->getMessage(),
            ]);

            Log::error("Import Error for Source {$source->id}: " . $e->getMessage());
            return false;
        }
    }
}
