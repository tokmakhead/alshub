<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngestionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_name',
        'content_type',
        'run_identifier',
        'fetched_count',
        'inserted_count',
        'updated_count',
        'failed_count',
        'status',
        'error_message',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
