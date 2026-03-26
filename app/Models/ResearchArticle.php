<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchArticle extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($article) {
            if (empty($article->slug)) {
                $article->slug = \Illuminate\Support\Str::slug($article->title) . '-' . ($article->pmid ?: uniqid());
            }
        });
    }

    protected $fillable = [
        'pmid',
        'doi',
        'title',
        'turkish_title',
        'slug',
        'abstract_original',
        'abstract_tr',
        'journal',
        'authors_json',
        'publication_date',
        'source_url',
        'raw_payload_json',
        'verification_tier',
        'status',
        'fetched_at',
        'last_verified_at',
    ];

    protected $casts = [
        'authors_json' => 'array',
        'raw_payload_json' => 'array',
        'publication_date' => 'date',
        'fetched_at' => 'datetime',
        'last_verified_at' => 'datetime',
    ];

    public function getDisplayTitleAttribute()
    {
        return $this->turkish_title ?: $this->title;
    }

    public function getDisplaySummaryAttribute()
    {
        return $this->abstract_tr ?: $this->abstract_original;
    }

    // Compatibility accessors for Home Page (Duck-typing with Content model)
    public function getTranslatedTitleAttribute()
    {
        return $this->turkish_title ?: $this->title;
    }

    public function getTranslatedSummaryAttribute()
    {
        return $this->abstract_tr ?: $this->abstract_original;
    }

    public function getTypeAttribute()
    {
        return 'publication';
    }

    public function getSourceLabelAttribute()
    {
        return $this->journal ?: 'PubMed';
    }
}
