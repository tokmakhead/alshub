<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceRegistry extends Model
{
    use HasFactory;

    protected $table = 'source_registry';

    protected $fillable = [
        'source_name',
        'source_mode',
        'verification_tier',
        'is_enabled',
        'config_json',
        'last_successful_sync',
        'last_failed_sync',
        'notes',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'config_json' => 'array',
        'last_successful_sync' => 'datetime',
        'last_failed_sync' => 'datetime',
    ];
}
