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

    public function getTargetModuleAttribute()
    {
        $name = strtolower($this->source_name);
        
        if (str_contains($name, 'pubmed')) return 'Bilimsel Araştırmalar';
        if (str_contains($name, 'clinicaltrials.gov')) return 'Klinik Çalışmalar';
        if (str_contains($name, 'who ictrp')) return 'Klinik Çalışmalar';
        if (str_contains($name, 'fda') || str_contains($name, 'ema')) return 'İlaç Onayları & Durumları';
        if (str_contains($name, 'guidelines')) return 'Klinik Rehberler';
        if (str_contains($name, 'neals') || str_contains($name, 'encals') || str_contains($name, 'mda')) return 'Uzmanlık Merkezleri & Ağlar';
        if (str_contains($name, 'association')) return 'Haberler & Destek';
        
        return 'Genel İçerik';
    }
}
