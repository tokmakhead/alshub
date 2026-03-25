<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ExpertCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'location_city', 'location_country', 
        'website_url', 'description', 'is_verified', 
        'logo_path', 'raw_metadata_json'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'raw_metadata_json' => 'array',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($center) {
            $center->slug = $center->slug ?? Str::slug($center->name);
        });
    }
}
