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
            $rss = simplexml_load_file($source->base_url);
            if (!$rss) {
                throw new \Exception("RSS URL could not be parsed: " . $source->base_url);
            }

            $count = 0;
            foreach ($rss->channel->item as $item) {
                $external_id = (string) $item->guid ?: (string) $item->link;
                $source_url = (string) $item->link;

                // Duplicate check
                if (Content::where('external_id', $external_id)->orWhere('source_url', $source_url)->exists()) {
                    continue;
                }

                $content = Content::create([
                    'type' => $source->type,
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                    'source_url' => $source_url,
                    'original_title' => (string) $item->title,
                    'original_summary' => (string) $item->description,
                    'external_id' => $external_id,
                    'language' => 'en',
                    'status' => 'draft',
                    'source_published_at' => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
                    'slug' => Str::slug((string) $item->title) . '-' . Str::random(5),
                ]);

                $count++;
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
