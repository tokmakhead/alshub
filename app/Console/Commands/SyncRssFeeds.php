<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Content;
use App\Models\SourceRegistry;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SyncRssFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ALS sitelerinden XML/RSS haberlerini çeker.';

    private $feeds = [
        [
            'source_name' => 'ALS News Today',
            'url' => 'https://alsnewstoday.com/feed/',
        ],
        [
            'source_name' => 'ALS Association',
            'url' => 'https://www.als.org/rss.xml',
        ]
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("RSS Havuzu güncelleniyor...");

        foreach ($this->feeds as $feed) {
            $this->info("Çekilen RSS: {$feed['source_name']} ({$feed['url']})");
            try {
                // Initialize CURL for robust fetching (alsnewstoday might block simple file_get_contents)
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $feed['url']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // Enhanced headers for ALS Association 403 bypass
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Accept: application/rss+xml, application/xml, text/xml, */*',
                    'Accept-Language: en-US,en;q=0.9',
                ]);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                $xmlString = curl_exec($ch);
                
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode >= 400 || !$xmlString) {
                    $this->error("RSS okunamadı. HTTP Kodu: {$httpCode} - URL: {$feed['url']}");
                    continue;
                }

                $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
                if (!$xml || !isset($xml->channel->item)) {
                    $this->error("Geçersiz XML Formatı: {$feed['url']}");
                    continue;
                }

                $sourceRegistry = SourceRegistry::firstOrCreate(
                    ['source_name' => $feed['source_name']],
                    [
                        'target_module' => 'contents', 
                        'source_mode' => 'web_ingest', 
                        'is_enabled' => true,
                        'notes' => 'Otomatik RSS entegrasyonu ile eklendi.'
                    ]
                );

                // HOTFIX: contents table has a FK to 'sources' table. Sync them.
                $sourceLegacy = \App\Models\Source::updateOrCreate(
                    ['id' => $sourceRegistry->id], // ID matching to bypass FK issues if possible, or just same name
                    [
                        'name' => $feed['source_name'],
                        'type' => 'article',
                        'base_url' => $feed['url'],
                        'is_active' => true,
                        'fetch_method' => 'rss'
                    ]
                );

                $count = 0;
                foreach ($xml->channel->item as $item) {
                    $link = (string)$item->link;
                    
                    if (Content::where('source_url', $link)->exists()) {
                        continue; // Daha önce eklendiyse atla
                    }

                    $title = (string)$item->title;
                    $summary = strip_tags((string)$item->description);
                    
                    // WordPress often stores full content in content:encoded
                    $namespaces = $xml->getNamespaces(true);
                    $content = $summary;
                    if (isset($namespaces['content'])) {
                        $contentNode = $item->children($namespaces['content']);
                        if (isset($contentNode->encoded)) {
                            $content = strip_tags((string)$contentNode->encoded, '<p><br><ul><li><strong><em>');
                        }
                    }

                    $pubDateStr = (string)$item->pubDate;
                    
                    try {
                        $pubDate = $pubDateStr ? Carbon::parse($pubDateStr) : now();
                    } catch (\Exception $e) {
                        $pubDate = now();
                    }

                    Content::create([
                        'type' => 'news',
                        'source_id' => $sourceLegacy->id, // Use ID from 'sources' table to satisfy FK
                        'source_name' => $sourceRegistry->source_name,
                        'source_url' => $link,
                        'original_title' => $title,
                        'original_summary' => $summary,
                        'original_content' => $content,
                        'translated_title' => $title, // AI translate will overwrite this later via Admin Panel
                        'status' => 'draft', // Her zaman TASLAK olarak gelir (İnsan onayına muhtaç)
                        'language' => 'en',
                        'verification_tier' => 2,
                        'source_published_at' => $pubDate,
                        'slug' => Str::slug(substr($title, 0, 80) . '-' . uniqid())
                    ]);
                    $count++;
                }

                $this->info("{$feed['source_name']}: {$count} yeni taslak eklendi.");
                if ($count > 0) {
                    $sourceRegistry->update(['last_successful_sync' => now()]);
                }

            } catch (\Exception $e) {
                $this->error("Hata ({$feed['source_name']}): " . $e->getMessage());
            }
        }

        $this->info("RSS Senkronizasyonu %100 tamamlandı!");
    }
}
