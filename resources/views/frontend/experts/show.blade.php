@extends('frontend.layout')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('experts.index') }}" class="inline-flex items-center text-indigo-600 font-bold mb-8 hover:opacity-75 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Merkez Listesine Dön
            </a>

            <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-100">
                <div class="p-10 md:p-16">
                    <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
                        <div>
                            <span class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest mb-4 inline-block">
                                {{ $center->location_country }} / {{ $center->location_city }}
                            </span>
                            <h1 class="text-3xl md:text-5xl font-black text-slate-800 leading-tight">
                                {{ $center->name }}
                            </h1>
                        </div>
                        @if($center->is_verified)
                            <div class="flex items-center bg-emerald-50 text-emerald-700 px-4 py-2 rounded-2xl border border-emerald-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span class="font-bold text-sm tracking-tight uppercase">Dünya Referans Merkezi</span>
                            </div>
                        @endif
                    </div>

                    <div class="prose prose-lg text-slate-600 mb-12 max-w-none leading-relaxed">
                        <p>{{ $center->description ?? 'Bu uzmanlık merkezi ALS araştırmaları ve hasta bakımı konusunda dünya çapında faaliyet göstermektedir.' }}</p>
                    </div>

                    @if($center->website_url)
                        <div class="mb-12">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Resmi Web Sayfası</h3>
                            <a href="{{ $center->website_url }}" target="_blank" class="inline-flex items-center bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-600 transition-colors shadow-lg shadow-slate-200">
                                Siteyi Ziyaret Et
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    @endif

                    <!-- Doctors Section -->
                    @if($center->doctors->isNotEmpty())
                        <div class="mt-16 pt-16 border-t border-slate-100">
                            <h2 class="text-2xl font-bold text-slate-800 mb-8">Bu Merkezdeki Uzmanlar</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($center->doctors as $doctor)
                                    <div class="p-4 bg-slate-50 rounded-2xl flex items-center border border-slate-100">
                                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mr-4 font-bold">
                                            {{ substr($doctor->first_name, 0, 1) }}{{ substr($doctor->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-slate-800 font-bold">{{ $doctor->title }} {{ $doctor->first_name }} {{ $doctor->last_name }}</div>
                                            <div class="text-slate-500 text-xs uppercase font-medium tracking-wide">{{ $doctor->specialty ?? 'Nöroloji Uzmanı' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
