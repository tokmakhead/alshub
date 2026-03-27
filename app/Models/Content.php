<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'type',
        'source_id',
        'source_name',
        'source_url',
        'original_title',
        'original_summary',
        'original_content',
        'translated_title',
        'translated_summary',
        'translated_content',
        'language',
        'status',
        'published_at',
        'source_published_at',
        'external_id',
        'raw_payload_json',
        'slug',
        'author',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'source_published_at' => 'datetime',
        'raw_payload_json' => 'array',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Frontend Accessibility / Display Accessors
     */
    public function getDisplayTitleAttribute()
    {
        return $this->translated_title ?: $this->original_title;
    }

    public function getDisplaySummaryAttribute()
    {
        return $this->translated_summary ?: ($this->original_summary ?: $this->original_content);
    }

    public function getSourceLabelAttribute()
    {
        return $this->source_name ?: 'ALSHub Haber';
    }

    public function getPublicationDateAttribute()
    {
        return $this->source_published_at ?: ($this->published_at ?: $this->created_at);
    }
}
