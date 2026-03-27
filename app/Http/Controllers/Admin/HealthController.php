<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function index()
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'storage' => $this->checkStorage(),
            'scheduler' => $this->checkScheduler(),
            'pubmed_api' => $this->checkUrl('https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi'),
            'clinical_trials_api' => $this->checkUrl('https://clinicaltrials.gov/api/v2/studies'),
            'gemini_api' => $this->checkGemini(),
        ];

        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'environment' => app()->environment(),
            'debug_mode' => config('app.debug') ? 'Açık' : 'Kapalı',
        ];

        return view('admin.health.index', compact('checks', 'systemInfo'));
    }

    protected function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'ok', 'message' => 'Bağlantı başarılı.'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function checkUrl($url)
    {
        try {
            $response = Http::timeout(5)->get($url);
            return $response->successful() || $response->status() == 400 // 400 is fine if we sent no params
                ? ['status' => 'ok', 'message' => 'Erişilebilir.']
                : ['status' => 'warning', 'message' => 'Hata Kodu: ' . $response->status()];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Bağlantı kurulamadı.'];
        }
    }

    protected function checkGemini()
    {
        $key = env('GEMINI_API_KEY');
        if (!$key) return ['status' => 'error', 'message' => 'API Key eksik.'];
        
        try {
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$key}", [
                'contents' => [['parts' => [['text' => 'ping']]]]
            ]);
            return $response->successful() 
                ? ['status' => 'ok', 'message' => 'Aktif.'] 
                : ['status' => 'warning', 'message' => 'API Hatası: ' . $response->status()];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Bağlantı hatası.'];
        }
    }

    protected function checkStorage()
    {
        $paths = [
            'logs' => storage_path('logs'),
            'framework' => storage_path('framework/views'),
            'app' => storage_path('app/public'),
        ];

        foreach ($paths as $name => $path) {
            if (!is_writable($path)) {
                return ['status' => 'error', 'message' => "Yazma izni eksik: {$name}"];
            }
        }

        return ['status' => 'ok', 'message' => 'Tüm klasörler yazılabilir.'];
    }

    protected function checkScheduler()
    {
        $lastSync = \App\Models\SourceRegistry::max('last_successful_sync');
        
        if (!$lastSync) {
            return ['status' => 'warning', 'message' => 'Henüz hiç senkronizasyon yapılmadı.'];
        }

        $diffHours = now()->diffInHours($lastSync);
        
        if ($diffHours > 24) {
            return ['status' => 'warning', 'message' => "Son senkronizasyon {$diffHours} saat önce yapıldı (Gecikme olabilir)."];
        }

        return ['status' => 'ok', 'message' => "Senkronizasyon güncel: " . $lastSync->format('d.m.Y H:i')];
    }
}
