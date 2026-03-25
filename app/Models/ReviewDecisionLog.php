<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewDecisionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'content_id',
        'decision',
        'reviewer_id',
        'notes',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
