<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalTrial extends Model
{
    use HasFactory;

    protected $fillable = [
        'nct_id',
        'title',
        'summary',
        'phase',
        'recruitment_status',
        'sponsor',
        'intervention',
        'countries_json',
        'locations_json',
        'source_url',
        'raw_payload_json',
        'verification_tier',
        'status',
        'fetched_at',
        'last_verified_at',
    ];

    protected $casts = [
        'countries_json' => 'array',
        'locations_json' => 'array',
        'raw_payload_json' => 'array',
        'fetched_at' => 'datetime',
        'last_verified_at' => 'datetime',
    ];
}企画制 (Kaldırıldı).
