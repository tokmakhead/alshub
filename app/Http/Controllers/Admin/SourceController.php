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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'base_url' => 'required|url',
            'fetch_method' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $source->update($validated);

        return redirect()->route('admin.sources.index')->with('success', 'Source updated successfully.');
    }

    public function destroy(\App\Models\Source $source)
    {
        $source->delete();
        return redirect()->route('admin.sources.index')->with('success', 'Source deleted successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function fetchNow(\App\Models\Source $source, \App\Services\ContentFetcherService $fetcher)
    {
        $result = $fetcher->fetchFromSource($source);
        
        if ($result) {
            return redirect()->back()->with('success', 'İçerik başarıyla çekildi.');
        }

        return redirect()->back()->with('error', 'İçerik çekilirken hata oluştu. Logları kontrol edin.');
    }
}
