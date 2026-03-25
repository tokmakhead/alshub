<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'pmid',
        'doi',
        'title',
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
}企画制 (Kaldırıldı).
