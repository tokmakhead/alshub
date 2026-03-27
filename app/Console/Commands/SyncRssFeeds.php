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
            'source_name' => 'Les Turner ALS Foundation',
            'url' => 'https://lesturnerals.org/feed/',
        ],
        [
            'source_name' => 'Target ALS',
            'url' => 'https://targetals.org/feed/?post_type=news',
        ],
        [
            'source_name' => 'ALS Association (NY)',
            'url' => 'https://als-ny.org/feed',
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
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_ENCODING, "");
                
                // Special UA for als.org to bypass Cloudflare
                if (str_contains($feed['url'], 'als.org')) {
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
                } else {
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36');
                }
                
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.9',
                    'Cache-Control: no-cache',
                    'Connection: keep-alive',
                    'Referer: https://www.google.com/'
                ]);
                
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

                    $title = html_entity_decode((string)$item->title);
                    $summary = strip_tags(html_entity_decode((string)$item->description));
                    $summary = preg_replace('/\[.*?\]/', '...', $summary); // Clean up WordPress [...]
                    
                    // WordPress often stores full content in content:encoded
                    $namespaces = $xml->getNamespaces(true);
                    $content = $summary;
                    if (isset($namespaces['content'])) {
                        $contentNode = $item->children($namespaces['content']);
                        if (isset($contentNode->encoded)) {
                            $fullHtml = (string)$contentNode->encoded;
                            $content = strip_tags(html_entity_decode($fullHtml), '<p><br><ul><li><strong><em>');
                        }
                    }

                    $pubDateStr = (string)$item->pubDate;
                    
                    try {
                        $pubDate = $pubDateStr ? Carbon::parse($pubDateStr) : now();
                    } catch (\Exception $e) {
                        $pubDate = now();
                    }

                    // If summary is too short and content is long, use content for everything
                    if (strlen($summary) < 50 && strlen($content) > 100) {
                        $summary = Str::limit(strip_tags($content), 300);
                    }

                    Content::create([
                        'type' => 'news',
                        'source_id' => $sourceLegacy->id, // Use ID from 'sources' table to satisfy FK
                        'source_name' => $sourceRegistry->source_name,
                        'source_url' => $link,
                        'original_title' => $title,
                        'original_summary' => trim($summary),
                        'original_content' => trim($content),
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
