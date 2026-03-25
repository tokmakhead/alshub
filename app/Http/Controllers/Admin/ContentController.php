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
        $query = \App\Models\Content::where('verification_tier', 3)
            ->with('source')
            ->latest();

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
            'translated_title' => 'required|string',
            'translated_summary' => 'required|string',
            'status' => 'required|in:draft,review,published,archived',
        ]);

        if ($validated['status'] === 'published' && !$content->published_at) {
            $content->published_at = now();
        }

        $content->update($validated);

        return redirect()->route('admin.contents.index')->with('success', 'İçerik başarıyla güncellendi.');
    }

    public function destroy(\App\Models\Content $content)
    {
        $content->delete();
        return redirect()->route('admin.contents.index')->with('success', 'İçerik silindi.');
    }

    public function deleteAll()
    {
        \App\Models\Content::where('verification_tier', 3)->delete();
        return redirect()->route('admin.contents.index')->with('success', 'Tüm arşiv içerikleri silindi.');
    }

    public function translate(\App\Models\Content $content, \App\Services\TranslationService $translationService)
    {
        $result = $translationService->translate($content);
        
        if ($result->translated_title && $result->translated_title != "[TR] " . $result->original_title) {
            return redirect()->back()->with('success', 'AI çevirisi başarıyla tamamlandı.');
        }

        return redirect()->back()->with('error', 'AI çevirisi yapılamadı. Lütfen API anahtarınızı ve internet bağlantınızı kontrol edin.');
    }
}
