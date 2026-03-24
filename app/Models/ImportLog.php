<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    protected $fillable = [
        'source_id',
        'status',
        'message',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
