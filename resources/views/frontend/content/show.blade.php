@extends('frontend.layout')

@section('title', $content->display_title . ' - ALSHub')

@section('content')
    @php
        $modelType = strtolower(class_basename($content));
        $typeLabel = match($modelType) {
            'researcharticle' => 'Bilimsel Araştırma',
            'clinicaltrial' => 'Klinik Çalışma',
            'drug' => 'İlaç Gelişmesi',
            'guideline' => 'Klinik Rehber',
            default => 'Haber'
        };
        $typeColor = match($modelType) {
            'researcharticle' => 'bg-emerald-600',
            'clinicaltrial' => 'bg-blue-600',
            'drug' => 'bg-purple-600',
            'guideline' => 'bg-orange-600',
            default => 'bg-gray-600'
        };
    @endphp

    <article class="max-w-4xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <span class="{{ $typeColor }} text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">
                    {{ $typeLabel }}
                </span>
                
                @if($modelType === 'clinicaltrial')
                    @php
                        $rawStatus = $content->raw_payload_json['protocolSection']['statusModule']['overallStatus'] ?? '';
                        $statusConfig = match(strtolower($rawStatus)) {
                            'recruiting' => ['label' => 'Kayıt Devam Ediyor', 'color' => 'bg-green-100 text-green-700 border-green-200'],
                            'active, not recruiting', 'not yet recruiting' => ['label' => 'Aktif / Yakında', 'color' => 'bg-blue-100 text-blue-700 border-blue-200'],
                            'completed' => ['label' => 'Tamamlandı', 'color' => 'bg-gray-100 text-gray-600 border-gray-200'],
                            'withdrawn', 'terminated', 'suspended' => ['label' => 'Durduruldu', 'color' => 'bg-red-100 text-red-700 border-red-200'],
                            default => ['label' => $rawStatus ?: 'Bilinmiyor', 'color' => 'bg-gray-100 text-gray-500 border-gray-200']
                        };
                    @endphp
                    <span class="text-[10px] font-black uppercase px-2 py-1 rounded-lg border {{ $statusConfig['color'] }}">
                        {{ $statusConfig['label'] }}
                    </span>
                @endif

                <span class="text-gray-400 text-sm font-medium">
                    {{ ($content->publication_date ?? $content->created_at)->translatedFormat('d F Y') }}
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-8">
                {{ $content->display_title }}
            </h1>
            
            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <div class="bg-white p-2 rounded-xl shadow-sm text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider">Doğrulanmış Kaynak</span>
                    <span class="text-sm font-bold text-gray-700">{{ $content->source_label }}</span>
                    @if($content->source_url)
                        <a href="{{ $content->source_url }}" target="_blank" class="text-primary text-xs ml-2 underline hover:text-blue-800 transition">Orijinal Kaynak &rarr;</a>
                    @endif
                </div>
                <div class="ml-auto">
                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-200">Tier {{ $content->verification_tier ?? 1 }}</span>
                </div>
            </div>
        </header>

        <!-- Content Body (AI Unified Summary) -->
        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed mb-16">
            @php
                $summary = $content->display_summary;
                $hasSections = str_contains($summary, '---');
                if($hasSections) {
                    $sections = explode('---', $summary);
                    $patientSummary = trim($sections[0]);
                    $technicalSummary = trim($sections[1] ?? '');
                } else {
                    $patientSummary = $summary;
                    $technicalSummary = null;
                }
            @endphp

            @if($technicalSummary)
                <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 mb-8">
                    <h3 class="text-blue-900 text-lg font-bold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21.48l.342-6.657L12 14.823l-.342.342L12 21.48z"></path></svg>
                        Hasta ve Yakınları İçin Anlatım
                    </h3>
                    <div class="text-gray-800 leading-relaxed">
                        {!! nl2br(e($patientSummary)) !!}
                    </div>
                </div>

                <div class="mt-12">
                    <h3 class="text-gray-900 text-lg font-bold mb-4 border-b pb-2">Teknik Özet (Uzmanlar İçin)</h3>
                    <div class="text-sm text-gray-600 leading-relaxed">
                        {!! nl2br($technicalSummary) !!}
                    </div>
                </div>
            @else
                <p class="text-lg text-gray-900 font-medium mb-8 leading-relaxed">
                    {!! nl2br(e($patientSummary)) !!}
                </p>
            @endif
        </div>

        <!-- Type Specific Details -->
        <div class="border-t border-gray-100 pt-10">
            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100">
                <h4 class="text-gray-800 font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Kayıt Bilgileri
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($modelType === 'researcharticle')
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase block">PMID / DOI</span>
                            <p class="text-sm text-gray-700 font-medium">
                                {{ $content->pmid }} 
                                @if($content->doi) | {{ $content->doi }} @endif
                            </p>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase block">Dergi</span>
                            <p class="text-sm text-gray-700 font-medium">{{ $content->journal }}</p>
                        </div>
                    @endif

                    @if($modelType === 'clinicaltrial')
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase block">NCT ID</span>
                            <p class="text-sm text-gray-700 font-medium">{{ $content->nct_id }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase block">Çalışma Durumu</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 uppercase">
                                @php
                                    $rawStatus = $content->raw_payload_json['protocolSection']['statusModule']['overallStatus'] ?? '';
                                    echo match(strtolower($rawStatus)) {
                                        'recruiting' => 'Kayıt Devam Ediyor',
                                        'active, not recruiting' => 'Aktif, Kayıt Kapalı',
                                        'completed' => 'Tamamlandı',
                                        'withdrawn' => 'Geri Çekildi',
                                        'suspended' => 'Askıya Alındı',
                                        'terminated' => 'Durduruldu',
                                        'not yet recruiting' => 'Henüz Başlamadı',
                                        default => $rawStatus ?: 'Bilinmiyor'
                                    };
                                @endphp
                            </span>
                        </div>
                    @endif

                    @if($modelType === 'drug')
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase block">Onay Durumları</span>
                            <div class="flex gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $content->is_approved_fda ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">FDA</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $content->is_approved_ema ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">EMA</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $content->is_approved_titck ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">TİTCK</span>
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase block">Son Güncelleme</span>
                        <p class="text-sm text-gray-700 font-medium italic">{{ $content->updated_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Disclaimer -->
        <div class="mt-12 p-6 bg-red-50 rounded-2xl border border-red-100 italic text-sm text-red-900/70">
            <strong>Tıbbi Uyarı:</strong> Bu içerik bilimsel kaynaklardan derlenmiştir. Hatalar veya eksik bilgiler içerebilir. Tedavi süreçlerinizde karar vermeden önce mutlaka doktorunuza danışınız.
        </div>
    </article>
@endsection
