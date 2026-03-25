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

    public function regionalStatuses()
    {
        return $this->hasMany(DrugRegionalStatus::class);
    }
}
