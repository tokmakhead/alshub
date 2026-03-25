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
            'pubmed_api' => $this->checkUrl('https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi'),
            'clinical_trials_api' => $this->checkUrl('https://clinicaltrials.gov/api/v2/studies'),
            'gemini_api' => $this->checkGemini(),
        ];

        return view('admin.health.index', compact('checks'));
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
}
