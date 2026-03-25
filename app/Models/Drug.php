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
        'source_name',
        'verification_tier',
        'status',
    ];

    protected $casts = [
        'is_approved_fda' => 'boolean',
        'is_approved_ema' => 'boolean',
        'is_approved_titck' => 'boolean',
        'last_verified_at' => 'datetime',
    ];

    public function getDisplayTitleAttribute()
    {
        return $this->name;
    }

    public function getDisplaySummaryAttribute()
    {
        return $this->description_tr ?: $this->description_original;
    }

    public function getSourceLabelAttribute()
    {
        return 'Therapeutic Update';
    }

    public function regionalStatuses()
    {
        return $this->hasMany(DrugRegionalStatus::class);
    }
}
