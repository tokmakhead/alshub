<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'generic_name',
        'brand_name',
        'slug',
        'indication',
        'description_original',
        'description_tr',
        'ai_summary',
        'is_approved_fda',
        'is_approved_ema',
        'is_approved_titck',
        'fda_link',
        'ema_link',
        'price_info',
        'accessibility_info',
        'source_name',
        'verification_tier',
        'status',
        'last_verified_at',
    ];

    protected $casts = [
        'is_approved_fda' => 'boolean',
        'is_approved_ema' => 'boolean',
        'is_approved_titck' => 'boolean',
        'last_verified_at' => 'datetime',
    ];

    public function getDisplayTitleAttribute()
    {
        return $this->brand_name ? "{$this->generic_name} ({$this->brand_name})" : $this->generic_name;
    }

    public function getDisplaySummaryAttribute()
    {
        return $this->ai_summary ?: ($this->description_tr ?: $this->description_original);
    }

    public function getSourceLabelAttribute()
    {
        return $this->source_name ?: 'İlaç Gelişmeleri';
    }

    public function regionalStatuses()
    {
        return $this->hasMany(DrugRegionalStatus::class);
    }
}
