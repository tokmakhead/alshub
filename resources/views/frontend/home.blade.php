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
                <h2 class="text-3xl font-bold text-gray-900">Bilimsel Gelişmeler</h2>
                <p class="text-gray-500 mt-2">En son araştırmalar, klinik çalışmalar ve onaylanan ilaçlar.</p>
            </div>
            <a href="{{ route('publications') }}" class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all">
                Tümünü Gör 
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        @php
            $scientificUpdates = collect($latestResearch ?? [])
                ->concat($latestTrials ?? [])
                ->concat($latestDrugs ?? [])
                ->map(function ($item) {
                    $modelClass = get_class($item);
                    $displayDate = $item->created_at; 
                    try {
                        $raw = is_string($item->raw_payload_json) ? json_decode($item->raw_payload_json, true) : ($item->raw_payload_json ?? []);
                        if ($modelClass === 'App\Models\ResearchArticle' && !empty($raw)) {
                            $y = $raw['MedlineCitation']['Article']['ArticleDate']['Year'] ?? 
                                 $raw['MedlineCitation']['Article']['Journal']['JournalIssue']['PubDate']['Year'] ?? 
                                 $raw['MedlineCitation']['DateCompleted']['Year'] ?? null;
                            $m = $raw['MedlineCitation']['Article']['ArticleDate']['Month'] ?? 
                                 $raw['MedlineCitation']['Article']['Journal']['JournalIssue']['PubDate']['Month'] ?? 
                                 $raw['MedlineCitation']['DateCompleted']['Month'] ?? '01';
                            $d = $raw['MedlineCitation']['Article']['ArticleDate']['Day'] ?? 
                                 $raw['MedlineCitation']['Article']['Journal']['JournalIssue']['PubDate']['Day'] ?? 
                                 $raw['MedlineCitation']['DateCompleted']['Day'] ?? '01';
                            if ($y) $displayDate = \Carbon\Carbon::parse("$y-$m-$d");
                            elseif (isset($item->publication_date) && $item->publication_date->year > 1970) $displayDate = $item->publication_date;
                        } elseif ($modelClass === 'App\Models\ClinicalTrial' && !empty($raw)) {
                            $rawDate = $raw['protocolSection']['statusModule']['lastUpdateSubmitDate'] ?? 
                                       $raw['protocolSection']['statusModule']['studyFirstPostDateStruct']['date'] ?? null;
                            if ($rawDate) $displayDate = \Carbon\Carbon::parse($rawDate);
                        } elseif ($modelClass === 'App\Models\Drug') {
                            $usStatus = $item->regionalStatuses->where('region', 'US')->first();
                            if ($usStatus) {
                                $drugRaw = is_string($usStatus->raw_payload_json) ? json_decode($usStatus->raw_payload_json, true) : ($usStatus->raw_payload_json ?? []);
                                $effTime = $drugRaw['effective_time'] ?? null;
                                if ($effTime && strlen($effTime) == 8) {
                                    $strDate = substr($effTime, 0, 4) . '-' . substr($effTime, 4, 2) . '-' . substr($effTime, 6, 2);
                                    $displayDate = \Carbon\Carbon::parse($strDate);
                                }
                            }
                        }
                    } catch (\Exception $e) { $displayDate = clone ($item->created_at); }
                    
                    $item->computed_sort_date = $displayDate;
                    return $item;
                })
                ->sortByDesc(fn($item) => $item->computed_sort_date->timestamp)
                ->take(6);

            $newsUpdates = collect($latestContents ?? [])
                ->map(function ($item) {
                    $displayDate = clone ($item->source_published_at ?? $item->published_at ?? $item->created_at);
                    $item->computed_sort_date = $displayDate;
                    return $item;
                })
                ->sortByDesc(fn($item) => $item->computed_sort_date->timestamp)
                ->take(6);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($scientificUpdates as $item)
                <x-content-card :item="$item" />
            @empty
                <div class="col-span-full text-center py-10 text-gray-400 font-bold italic">
                    Henüz yeni bir bilimsel güncelleme bulunmuyor.
                </div>
            @endforelse
        </div>
    </div>

    @if(isset($latestGuidelines) && $latestGuidelines->count() > 0)
    <!-- Clinical Guidelines Section -->
    <div class="bg-slate-900 py-20 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-white">Klinik Rehberler ve Bakım</h2>
                    <p class="text-slate-400 mt-2">Uluslararası otoriteler (AAN, NICE vb.) tarafından onaylanan resmi bakım protokolleri.</p>
                </div>
                <a href="{{ route('guidelines') }}" class="text-indigo-400 font-bold flex items-center gap-2 hover:text-white transition-all">
                    Tüm Kütüphaneyi Gör 
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestGuidelines as $guideline)
                    <a href="{{ route('content.show', ['type' => 'guideline', 'slug' => $guideline->slug]) }}" class="group bg-slate-800/50 p-8 rounded-[2rem] border border-slate-700 hover:bg-slate-800 hover:border-indigo-500 transition-all duration-300 flex flex-col h-full">
                        <div class="mb-6 flex justify-between items-start">
                            <div class="bg-indigo-500/10 text-indigo-400 p-3 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            @if($guideline->verification_tier == 1)
                                <span class="bg-emerald-500/10 text-emerald-400 text-[10px] font-bold px-2 py-1 rounded-lg tracking-widest uppercase">GÜVENİLİR</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors line-clamp-2">
                            {{ $guideline->title }}
                        </h3>
                        <p class="text-slate-400 text-sm mb-6 line-clamp-3">
                            {{ $guideline->display_summary }}
                        </p>
                        <div class="mt-auto flex items-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <span class="text-indigo-500 mr-2">●</span> {{ $guideline->source_org }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if($newsUpdates->count() > 0)
    <!-- News & Blog Section -->
    <div class="bg-blue-50/50 border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">ALS Dünyasından Haberler</h2>
                    <p class="text-gray-500 mt-2">Uluslararası ALS dernekleri, organizasyonlar ve ağlardan (NEALS, EMA vb.) derlenen güncel gelişmeler.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($newsUpdates as $item)
                    <x-content-card :item="$item" />
                @endforeach
            </div>
        </div>
    </div>
    @endif

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
