<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugRegionalStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'drug_id',
        'region',
        'regulator_name',
        'external_id',
        'indication',
        'approval_status',
        'approval_date',
        'label_url',
        'change_detected',
        'raw_payload_json',
        'fetched_at',
        'last_verified_at',
    ];

    protected $casts = [
        'approval_date' => 'date',
        'change_detected' => 'boolean',
        'raw_payload_json' => 'array',
        'fetched_at' => 'datetime',
        'last_verified_at' => 'datetime',
    ];

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
