@extends('frontend.layout')
{{-- UI Modernization Phase --}}

@section('content')
    <!-- Hero Section -->
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden border-b border-gray-100">
        <!-- Subtle Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%230f4c81\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8 relative text-center">
            <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 tracking-tight leading-tight">
                ALS Hakkında Bilgiye <br/>
                <span class="text-primary bg-blue-50 px-4 rounded-2xl">Güvenilir</span> Erişim
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed mb-12 font-medium">
                Dünya çapındaki gelişmeleri, klinik çalışmaları ve resmi rehberleri <br class="hidden md:block"/> yapay zeka desteğiyle anında Türkçe olarak takip edin.
            </p>
            
            <!-- Quick Search Center -->
            <div class="max-w-xl mx-auto mb-16 relative group">
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" placeholder="Hangi konuyu merak ediyorsunuz? (Kök Hücre, Tofersen, Beslenme...)" 
                           class="w-full pl-14 pr-6 py-5 bg-white border-2 border-gray-100 rounded-[2rem] shadow-2xl shadow-blue-100 focus:border-primary focus:outline-none transition-all group-hover:border-blue-200">
                    <svg class="w-6 h-6 text-gray-400 absolute left-5 top-5 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <button type="submit" class="absolute right-3 top-3 bg-primary text-white px-6 py-2.5 rounded-2xl font-bold hover:bg-blue-900 transition shadow-lg">Ara</button>
                </form>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto bg-white/80 backdrop-blur p-8 rounded-[2.5rem] border border-gray-50 shadow-sm">
                <div class="text-center group">
                    <div class="text-3xl font-black text-primary mb-1 group-hover:scale-110 transition-transform">{{ number_format($stats['research'] ?? 0) }}</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bilimsel Makale</div>
                </div>
                <div class="text-center group border-l border-gray-100">
                    <div class="text-3xl font-black text-emerald-600 mb-1 group-hover:scale-110 transition-transform">{{ number_format($stats['trials'] ?? 0) }}</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Klinik Çalışma</div>
                </div>
                <div class="text-center group border-l border-gray-100">
                    <div class="text-3xl font-black text-purple-600 mb-1 group-hover:scale-110 transition-transform">{{ number_format($stats['drugs'] ?? 0) }}</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Onaylı İlaç</div>
                </div>
                <div class="text-center group border-l border-gray-100">
                    <div class="text-3xl font-black text-orange-500 mb-1 group-hover:scale-110 transition-transform">{{ number_format($stats['guidelines'] ?? 0) }}</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bakım Rehberi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Icons -->
    <div class="max-w-7xl mx-auto px-4 -mt-10 relative z-10 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('publications') }}" class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-900/[0.03] hover:shadow-2xl hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.346a6 6 0 01-3.86.517l-2.387-.477a2 2 0 00-1.022.547l-1.168 1.168a2 2 0 00.566 3.414l9.74 1.391a2 2 0 001.166-.2l9.74-5.566a2 2 0 00.566-3.414l-1.168-1.168z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Makaleleri Keşfedin</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Dünyadaki en önemli ALS araştırmalarının yapay zeka özetleri.</p>
            </a>
            <a href="{{ route('trials') }}" class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-900/[0.03] hover:shadow-2xl hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Klinik Çalışmalar</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Devam eden ve hasta kabul eden klinik deneyleri takip edin.</p>
            </a>
            <a href="{{ route('guidelines') }}" class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-900/[0.03] hover:shadow-2xl hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Bakım Rehberleri</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Uluslararası otoritelerin hazırladığı profesyonel bakım kılavuzları.</p>
            </a>
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
                            <div class="flex flex-col items-end gap-2">
                                @if($guideline->verification_tier == 1)
                                    <span class="bg-emerald-500/10 text-emerald-400 text-[10px] font-bold px-2 py-1 rounded-lg tracking-widest uppercase items-center">GÜVENİLİR</span>
                                @endif
                                <span class="text-[10px] text-slate-500 font-bold tracking-tighter">{{ $guideline->publication_date->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors line-clamp-2">
                            {{ $guideline->display_title }}
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
