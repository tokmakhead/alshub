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

    public function create()
    {
        // Tüm aktif kurumsal kaynakları (API ve Manuel dahil) Source Dropdown için çek
        $sources = \App\Models\SourceRegistry::where('is_enabled', true)
            ->orderBy('source_name')
            ->get();
            
        return view('admin.contents.create', compact('sources'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'source_id' => 'required|exists:source_registries,id',
            'type' => 'required|string',
            'status' => 'required|in:draft,review,published,archived',
            'original_title' => 'required|string',
            'original_summary' => 'nullable|string',
            'original_content' => 'nullable|string',
            'translated_title' => 'required|string',
            'translated_summary' => 'nullable|string',
            'translated_content' => 'nullable|string',
            'source_url' => 'nullable|url',
            'source_published_at' => 'nullable|date',
        ]);

        // Veritabanı tutarlılığı için ek alanları hazırla
        $source = \App\Models\SourceRegistry::find($validated['source_id']);
        $validated['source_name'] = $source->source_name ?? 'Manuel Kaynak';
        $validated['verification_tier'] = 3; // En yüksek güven derecesi (Admin manuel girdiği için)
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['translated_title'] . '-' . uniqid());
        $validated['language'] = 'en';

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        \App\Models\Content::create($validated);

        return redirect()->route('admin.contents.index')->with('success', '✅ Yeni içerik başarıyla oluşturuldu ve havuza eklendi.');
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
