<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Temizlik: Sıkışmış (stuck) import durumlarını bir kereliğine temizle
        if (request()->has('reset_stuck')) {
            $updated = \App\Models\Source::where('is_importing', true)->update(['is_importing' => false, 'import_progress' => 0]);
            \Illuminate\Support\Facades\Log::info("DEBUG: Sources reset by request. Updated count: " . $updated);
        }
        
        $sources = \App\Models\Source::latest()->paginate(10);
        return view('admin.sources.index', compact('sources'));
    }

    public function create()
    {
        return view('admin.sources.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'base_url' => 'required|url',
            'fetch_method' => 'required|string',
        ]);

        \App\Models\Source::create($validated);

        return redirect()->route('admin.sources.index')->with('success', 'Source created successfully.');
    }

    public function edit(\App\Models\Source $source)
    {
        return view('admin.sources.edit', compact('source'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Source $source)
    {
        \Illuminate\Support\Facades\Log::info("RAW Request base_url arriving: '" . $request->input('base_url') . "'");
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'base_url' => 'required|string', // Changed from url to string for debugging
            'fetch_method' => 'required|string',
            'is_active' => 'boolean',
        ]);

        \Illuminate\Support\Facades\Log::info("Updating Source ID: " . $source->id);
        \Illuminate\Support\Facades\Log::info("Base URL Length after validation: " . strlen($validated['base_url']));

        $source->update($validated);

        return redirect()->route('admin.sources.index')->with('success', 'Source updated successfully.');
    }

    public function destroy(\App\Models\Source $source)
    {
        $source->delete();
        return redirect()->route('admin.sources.index')->with('success', 'Source deleted successfully.');
    }

    public function fetchNow(\App\Models\Source $source, \App\Services\ContentFetcherService $fetcher)
    {
        try {
            \Log::info("DEBUG: fetchNow manual trigger for Source " . $source->id);
            // Start process
            $fetcher->fetchFromSource($source);
            
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Veri çekme işlemi tamamlandı.');
        } catch (\Exception $e) {
            \Log::error("DEBUG: fetchNow exception: " . $e->getMessage());
            if (request()->ajax()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
            throw $e;
        }
    }

    public function checkProgress(\App\Models\Source $source)
    {
        return response()->json([
            'is_importing' => $source->is_importing,
            'progress' => $source->import_progress,
            'message' => $source->import_message,
        ]);
    }
}
