<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'expert_center_id', 'first_name', 'last_name', 'slug', 
        'title', 'specialty', 'biography', 'orcid_id', 
        'researchgate_url', 'is_verified', 'profile_image_path'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function center()
    {
        return $this->belongsTo(ExpertCenter::class, 'expert_center_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->title} {$this->first_name} {$this->last_name}";
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($doctor) {
            $doctor->slug = $doctor->slug ?? Str::slug($doctor->first_name . ' ' . $doctor->last_name);
        });
    }
}
