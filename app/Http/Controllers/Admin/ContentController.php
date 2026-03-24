<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Content::with('source')->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $contents = $query->paginate(15);
        return view('admin.contents.index', compact('contents'));
    }

    public function edit(\App\Models\Content $content)
    {
        return view('admin.contents.edit', compact('content'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Content $content)
    {
        $validated = $request->validate([
            'translated_title' => 'required|string|max:255',
            'translated_summary' => 'required|string',
            'status' => 'required|in:draft,review,published,archived',
        ]);

        if ($validated['status'] === 'published' && !$content->published_at) {
            $content->published_at = now();
        }

        $content->update($validated);

        return redirect()->route('admin.contents.index')->with('success', 'Content updated successfully.');
    }

    public function destroy(\App\Models\Content $content)
    {
        $content->delete();
        return redirect()->route('admin.contents.index')->with('success', 'Content deleted successfully.');
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
}
