@extends('frontend.layout')

@section('content')
    <!-- Hero Section -->
    <div class="bg-white border-b border-gray-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 tracking-tight">ALS Hakkında Bilgiye <span class="text-primary tracking-normal">Güvenilir</span> Erişim</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed mb-10">
                Gelişmeleri, klinik çalışmaları ve ilaç araştırmalarını Türkçe olarak takip edin.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('publications') }}" class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-blue-900 transition shadow-lg shadow-blue-100">Araştırmaları İncele</a>
                <a href="{{ route('about.als') }}" class="bg-white text-primary border border-primary px-8 py-3 rounded-full font-bold hover:bg-blue-50 transition">ALS Nedir?</a>
            </div>
        </div>
    </div>

    <!-- Latest Content -->
    <div class="max-w-7xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Son Güncellemeler</h2>
                <p class="text-gray-500 mt-2">Dünyadan derlenen en son haberler ve araştırmalar.</p>
            </div>
            <a href="{{ route('publications') }}" class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all">
                Tümünü Gör 
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestContents as $content)
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all group flex flex-col h-full">
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xs font-bold uppercase tracking-widest text-primary bg-blue-50 px-3 py-1 rounded-full">
                                {{ $content->type === 'publication' ? 'Araştırma' : ($content->type === 'trial' ? 'Klinik Çalışma' : 'İlaç') }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">{{ $content->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-primary transition">
                            <a href="{{ route('content.show', $content->slug) }}">{{ $content->translated_title }}</a>
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                            {{ $content->translated_summary }}
                        </p>
                        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs text-gray-400">Kaynak: <span class="font-bold text-gray-600">{{ $content->source->name ?? $content->source_name }}</span></span>
                            <a href="{{ route('content.show', $content->slug) }}" class="text-primary font-bold text-sm">Detaylar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Disclaimer Banner -->
    <div class="max-w-7xl mx-auto px-4 pb-20 sm:px-6 lg:px-8">
        <div class="bg-blue-50 rounded-3xl p-10 flex flex-col md:flex-row items-center gap-8 border border-blue-100">
            <div class="bg-white p-4 rounded-2xl shadow-sm">
                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-primary mb-2 italic">Bilgilendirme Amaçlıdır</h3>
                <p class="text-blue-900/70 leading-relaxed text-sm">
                    ALSHub platformunda sunulan bilgiler tıbbi tavsiye niteliği taşımaz. Araştırmalar ve klinik çalışmaların özetleri, yalnızca bilgiye erişimi kolaylaştırmak için sunulmaktadır. Herhangi bir tedavi değişikliği veya ilaç kullanımı için mutlaka doktorunuza başvurunuz.
                </p>
            </div>
        </div>
    </div>
@endsection
