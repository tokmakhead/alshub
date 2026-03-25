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
        if ($source->fetch_method === 'rss') {
            return $this->fetchFromRss($source);
        }

        return false;
    }

    protected function fetchFromRss(Source $source)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept' => 'application/rss+xml, application/xml;q=0.9, */*;q=0.8',
            ])->timeout(30)->get($source->base_url);

            if (!$response->successful()) {
                throw new \Exception("Could not fetch RSS. HTTP Status: " . $response->status());
            }

            $rss = simplexml_load_string($response->body());
            
            if (!$rss) {
                \Illuminate\Support\Facades\Log::error("RSS Parse Error Body: " . substr($response->body(), 0, 1000));
                throw new \Exception("RSS content could not be parsed as valid XML. Check Laravel logs for raw response.");
            }

            $count = 0;
            foreach ($rss->channel->item as $item) {
                $external_id = (string) $item->guid ?: (string) $item->link;
                $source_url = (string) $item->link;

                // Duplicate check
                if (Content::where('external_id', $external_id)->orWhere('source_url', $source_url)->exists()) {
                    continue;
                }

                $original_summary = (string) $item->description;

                // Try to fetch full abstract from the link if it seems truncated
                try {
                    $pageResponse = \Illuminate\Support\Facades\Http::withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                    ])->timeout(10)->get($source_url);

                    if ($pageResponse->successful()) {
                        $html = $pageResponse->body();
                        // Extract abstract content using simple regex or string manipulation
                        if (class_exists('DOMDocument')) {
                            $doc = new \DOMDocument();
                            @$doc->loadHTML('<?xml encoding="UTF-8">' . $html);
                            $xpath = new \DOMXPath($doc);
                            $abstractNodes = $xpath->query('//div[contains(@class, "abstract-content")]/p');
                            if ($abstractNodes->length > 0) {
                                $fullAbstract = "";
                                foreach ($abstractNodes as $node) {
                                    $fullAbstract .= trim($node->textContent) . "\n\n";
                                }
                                if (!empty(trim($fullAbstract))) {
                                    $original_summary = trim($fullAbstract);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Could not scrape full abstract for {$source_url}: " . $e->getMessage());
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

                $count++;

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

            return true;

        } catch (\Exception $e) {
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
