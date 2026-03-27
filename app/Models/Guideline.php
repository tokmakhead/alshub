<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guideline extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_org', 'external_id', 'title', 'title_tr', 'slug', 
        'summary_original', 'summary_tr', 'full_text_html', 
        'pdf_url', 'source_url', 'publication_date', 'last_updated_at',
        'status', 'verification_tier', 'raw_payload_json'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'last_updated_at' => 'date',
        'raw_payload_json' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($guideline) {
            $guideline->slug = $guideline->slug ?? Str::slug($guideline->title . '-' . $guideline->source_org);
        });
    }

    public function getDisplayTitleAttribute()
    {
        return $this->title_tr ?: $this->title;
    }

    public function getDisplaySummaryAttribute()
    {
        return $this->summary_tr ?: $this->summary_original;
    }

    public function getSourceLabelAttribute()
    {
        return $this->source_org ?: 'Klinik Rehber';
    }
}
