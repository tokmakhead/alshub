@extends('frontend.layout')

@section('title', $content->translated_title . ' - ALSHub')

@section('content')
    <article class="max-w-4xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-blue-600 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">
                    {{ $content->type === 'publication' ? 'Araştırma' : ($content->type === 'trial' ? 'Klinik Çalışma' : 'İlaç') }}
                </span>
                <span class="text-gray-400 text-sm font-medium">{{ $content->created_at->translatedFormat('d F Y') }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-8">
                {{ $content->translated_title }}
            </h1>
            
            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <div class="bg-white p-2 rounded-xl shadow-sm text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider">İçerik Kaynağı</span>
                    <span class="text-sm font-bold text-gray-700">{{ $content->source->name ?? $content->source_name }}</span>
                    @if($content->source_url)
                        <a href="{{ $content->source_url }}" target="_blank" class="text-primary text-xs ml-2 underline hover:text-blue-800 transition">Orijinal İçeriğe Git &rarr;</a>
                    @endif
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed mb-16">
            <p class="text-lg text-gray-900 font-medium mb-8 leading-relaxed">
                {!! nl2br(e($content->translated_summary)) !!}
            </p>
            
            @if($content->translated_content)
                <div class="mt-10">
                    {!! $content->translated_content !!}
                </div>
            @endif
        </div>

        <!-- Meta Info -->
        <div class="border-t border-gray-100 pt-10">
            <div class="bg-blue-50 rounded-2xl p-8 border border-blue-100">
                <h4 class="text-blue-900 font-bold mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Orijinal Bilgiler
                </h4>
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-bold text-blue-900/60 uppercase block">Orijinal Başlık</span>
                        <p class="text-sm text-blue-900 font-medium italic">{{ $content->original_title }}</p>
                    </div>
                    @if($content->author)
                        <div>
                            <span class="text-xs font-bold text-blue-900/60 uppercase block">Yazar / Organizasyon</span>
                            <p class="text-sm text-blue-900 font-medium">{{ $content->author }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Disclaimer -->
        <div class="mt-12 p-6 bg-red-50 rounded-2xl border border-red-100 italic text-sm text-red-900/70">
            <strong>Tıbbi Uyarı:</strong> Bu içerik, yabancı dildeki orijinal kaynağından Türkçe'ye özetlenerek çevrilmiştir. Hatalar veya eksik bilgiler içerebilir. Tedavi süreçlerinizde karar vermeden önce mutlaka doktorunuza danışınız ve mümkünse orijinal kaynağı inceleyiniz.
        </div>
    </article>
@endsection
