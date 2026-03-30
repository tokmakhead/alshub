<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SourceRegistry;
use App\Models\IngestionLog;
use App\Services\IngestionManager;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        $sources = SourceRegistry::latest()->get();
        return view('admin.sources.index', compact('sources'));
    }

    public function create()
    {
        return view('admin.sources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source_name' => 'required|string|max:255',
            'logo_url' => 'nullable|url|max:2048',
            'official_url' => 'nullable|url|max:2048',
            'source_mode' => 'required|in:api,web_ingest,manual',
            'notes' => 'nullable|string',
        ]);

        SourceRegistry::create($validated);
        return redirect()->route('admin.sources.index')->with('success', 'Kaynak başarıyla eklendi.');
    }

    public function edit(SourceRegistry $source)
    {
        return view('admin.sources.edit', compact('source'));
    }

    public function update(Request $request, SourceRegistry $source)
    {
        $validated = $request->validate([
            'source_name' => 'required|string|max:255',
            'logo_url' => 'nullable|url|max:2048',
            'official_url' => 'nullable|url|max:2048',
            'source_mode' => 'required|in:api,web_ingest,manual',
            'is_enabled' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $source->update($validated);
        return redirect()->route('admin.sources.index')->with('success', 'Kaynak durum güncellendi.');
    }

    public function fetchNow(SourceRegistry $source, IngestionManager $manager)
    {
        // Check mode and trigger proper sync
        if ($source->source_mode === 'manual') {
            return response()->json(['error' => 'Bu kaynak manuel veri girişi gerektirir.'], 400);
        }

        switch($source->source_name) {
            case 'PubMed':
                $log = $manager->syncPubMed($source);
                break;
            case 'ClinicalTrials.gov':
                $log = $manager->syncTrials($source);
                break;
            case 'OpenFDA':
                $log = $manager->syncDrugs($source);
                break;
            default:
                return response()->json(['error' => 'Bu kaynak için otomatik senkronizasyon henüz yapılandırılmadı.'], 400);
        }

        return response()->json([
            'success' => true, 
            'message' => $log->status === 'success' ? 'Senkronizasyon tamamlandı.' : 'Hata: ' . $log->error_message,
            'log_id' => $log->id
        ]);
    }

    public function checkProgress(SourceRegistry $source)
    {
        // Simple mock for UI compatibility, real progress would need job tracking
        return response()->json([
            'is_importing' => false,
            'progress' => 100,
            'message' => 'Tamamlandı'
        ]);
    }

    public function destroy(SourceRegistry $source)
    {
        $source->delete();
        return redirect()->route('admin.sources.index')->with('success', 'Kaynak kaldırıldı.');
    }
}
