@extends('frontend.layout')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Header & Search -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-slate-800 mb-4">Uzmanlık Merkezleri ve Klinikler</h1>
            <p class="text-slate-600 max-w-2xl mx-auto mb-8">
                Dünya çapındaki en saygın ALS araştırma ve tedavi merkezlerine ulaşın. Şehir veya ülke bazlı arama yapabilirsiniz.
            </p>
            
            <form action="{{ route('experts.index') }}" method="GET" class="max-w-xl mx-auto relative">
                <input type="text" name="q" value="{{ request('q') }}" 
                    placeholder="Şehir, ülke veya merkez ismi ara..." 
                    class="w-full pl-12 pr-4 py-4 rounded-2xl border-none shadow-lg focus:ring-2 focus:ring-indigo-500 text-slate-700">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>

        @if($centers->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm">
                <p class="text-slate-500 text-lg">Aradığınız kriterlere uygun merkez bulunamadı.</p>
                <a href="{{ route('experts.index') }}" class="mt-4 inline-block text-indigo-600 font-semibold underline">Tüm listeye dön</a>
            </div>
        @else
            <!-- Centers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($centers as $center)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col h-full group">
                        <div class="p-8 flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <div class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase">
                                    {{ $center->location_country }}
                                </div>
                                @if($center->is_verified)
                                    <div class="flex items-center text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tighter" title="Doğrulanmış Uzmanlık Merkezi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        REFERANS
                                    </div>
                                @endif
                            </div>
                            
                            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">
                                {{ $center->name }}
                            </h3>
                            
                            <div class="flex items-center text-slate-500 text-sm mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $center->location_city }}
                            </div>
                            
                            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                                {{ $center->description ?? 'Bu merkez hakkında detaylı bilgi bulunmamaktadır.' }}
                            </p>

                            @if($center->doctors_count > 0)
                                <div class="flex items-center text-xs font-medium text-slate-400 bg-slate-50 px-3 py-2 rounded-xl border border-dashed border-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $center->doctors_count }} Kayıtlı Uzman
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            @if($center->website_url)
                                <a href="{{ $center->website_url }}" target="_blank" class="text-indigo-600 text-sm font-bold flex items-center hover:opacity-80">
                                    Web Sitesi
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                            <a href="{{ route('experts.show', $center->slug) }}" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-slate-800 transition-colors">
                                Detaylar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $centers->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
