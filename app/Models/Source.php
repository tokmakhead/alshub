<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = [
        'name',
        'type',
        'base_url',
        'is_active',
        'fetch_method',
        'config_json',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config_json' => 'array',
    ];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function importLogs()
    {
        return $this->hasMany(ImportLog::class);
    }
}
