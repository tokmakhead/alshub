<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function publications()
    {
        $contents = \App\Models\Content::where('type', 'publication')->where('status', 'published')->latest()->paginate(12);
        $title = "Araştırmalar / Yayınlar";
        return view('frontend.content.index', compact('contents', 'title'));
    }

    public function trials()
    {
        $contents = \App\Models\Content::where('type', 'trial')->where('status', 'published')->latest()->paginate(12);
        $title = "Klinik Çalışmalar";
        return view('frontend.content.index', compact('contents', 'title'));
    }

    public function drugs()
    {
        $contents = \App\Models\Content::where('type', 'drug')->where('status', 'published')->latest()->paginate(12);
        $title = "İlaçlar / Tedavi Gelişmeleri";
        return view('frontend.content.index', compact('contents', 'title'));
    }

    public function show($slug)
    {
        $content = \App\Models\Content::where('slug', $slug)->firstOrFail();
        return view('frontend.content.show', compact('content'));
    }

    public function search(\Illuminate\Http\Request $request)
    {
        $term = $request->input('q');
        $contents = \App\Models\Content::where('status', 'published')
            ->where(function($query) use ($term) {
                $query->where('translated_title', 'like', "%{$term}%")
                      ->orWhere('translated_summary', 'like', "%{$term}%")
                      ->orWhere('original_title', 'like', "%{$term}%");
            })
            ->latest()
            ->paginate(12);
        
        $title = "'{$term}' için Arama Sonuçları";
        return view('frontend.content.index', compact('contents', 'title'));
    }
}
