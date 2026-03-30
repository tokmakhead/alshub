@extends('frontend.layout')

@section('title', 'Hakkımızda - ALSHub')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-white pt-16 pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 tracking-tighter">
                    Küresel Bilim, <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-400 font-extrabold italic">Yerel Bilgi.</span>
                </h1>
                <p class="max-w-2xl mx-auto text-xl text-gray-500 leading-relaxed font-medium">
                    ALSHub, en yeni bilimsel gelişmeleri ve klinik araştırmaları, herkes için erişilebilir kılmak amacıyla yola çıkmış bir dijital sağlık platformudur.
                </p>
            </div>
        </div>
        
        <!-- Decoration -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full opacity-5 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0,100 C20,80 40,80 60,100 C80,120 100,120 120,100" stroke="currentColor" fill="none" />
            </svg>
        </div>
    </div>

    <!-- Live Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 text-center group hover:-translate-y-2 transition-all duration-300">
                <div class="text-4xl font-black text-primary mb-2">{{ number_format($stats['research']) }}+</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Bilimsel Makale</div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 text-center group hover:-translate-y-2 transition-all duration-300">
                <div class="text-4xl font-black text-primary mb-2">{{ number_format($stats['trials']) }}+</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Klinik Çalışma</div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 text-center group hover:-translate-y-2 transition-all duration-300">
                <div class="text-4xl font-black text-primary mb-2">{{ number_format($stats['drugs']) }}+</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">İlaç Gelişmesi</div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 text-center group hover:-translate-y-2 transition-all duration-300">
                <div class="text-4xl font-black text-primary mb-2">{{ number_format($stats['guidelines']) }}+</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Bakım Rehberi</div>
            </div>
        </div>
    </div>

    <!-- How We Work Section -->
    <div class="py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-gray-900 mb-4">Nasıl Çalışıyoruz?</h2>
                <p class="text-gray-500">Bilginin kaynağından size ulaşana kadarki şeffaf yolculuğu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative">
                <!-- Connectors for Desktop -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -translate-y-1/2 z-0"></div>
                
                <!-- Step 1 -->
                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 bg-white border border-gray-100 shadow-lg rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9-9H3m9 9L3 18m0 0l-3-3m3 3l3-3"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Global Tarama</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">PubMed, FDA ve ClinicalTrials.gov üzerinden 7/24 veri takibi yapıyoruz.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 bg-white border border-gray-100 shadow-lg rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0012 18.75c-1.03 0-1.959-.462-2.589-1.189l-.548-.547z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">AI Analizi</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Yapay zeka modellerimiz ile teknik verileri herkesin anlayabileceği dile çeviriyoruz.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 bg-white border border-gray-100 shadow-lg rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Uzman Kontrolü</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Derlenen bilgiler, doğruluğu ve güncelliği açısından manuel olarak son denetimden geçer.</p>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 bg-white border border-gray-100 shadow-lg rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Hızlı Paylaşım</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Onaylanan her içerik, şeffaf kaynak bağlantılarıyla birlikte anında yayınlanır.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Values -->
    <div class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 mb-8 leading-tight">Bilgi Kirliliğine Karşı Doğru Verinin Gücü.</h2>
                    <div class="prose prose-blue text-gray-500 max-w-none">
                        <p class="text-lg mb-6">
                            ALS gibi karmaşık ve hızlı seyreden hastalıklarda, zamana karşı yarışta en büyük engel yanlış veya eksik bilgidir. ALSHub olarak biz, her içeriğimizi global otoritelerin yayınlarıyla doğrulamaktayız.
                        </p>
                        <p class="text-lg">
                            Amacımız sadece haber vermek değil; hasta, hasta yakını ve araştırma topluluğu arasında güvenilir bir bilgi köprüsü kurmaktır.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-8 rounded-[2rem] border border-blue-100">
                        <span class="text-3xl block mb-4">🏆</span>
                        <h4 class="font-bold text-gray-900 mb-2 text-lg">Doğruluk</h4>
                        <p class="text-sm text-blue-900/60 leading-relaxed">Her verimiz orijinal akademik karşılığına veya resmi kurum onayına dayalıdır.</p>
                    </div>
                    <div class="bg-indigo-50 p-8 rounded-[2rem] border border-indigo-100">
                        <span class="text-3xl block mb-4">⚡</span>
                        <h4 class="font-bold text-gray-900 mb-2 text-lg">Hız</h4>
                        <p class="text-sm text-indigo-900/60 leading-relaxed">Globaldeki önemli sismik değişimler, AI gücüyle saatler içinde Türkçe'ye kazandırılır.</p>
                    </div>
                    <div class="bg-emerald-50 p-8 rounded-[2rem] border border-emerald-100">
                        <span class="text-3xl block mb-4">🌍</span>
                        <h4 class="font-bold text-gray-900 mb-2 text-lg">Erişilebilirlik</h4>
                        <p class="text-sm text-emerald-900/60 leading-relaxed">Karmaşık tıp terminolojisini, herkesin anlayabileceği duru bir dile çeviriyoruz.</p>
                    </div>
                    <div class="bg-amber-50 p-8 rounded-[2rem] border border-amber-100">
                        <span class="text-3xl block mb-4">🤝</span>
                        <h4 class="font-bold text-gray-900 mb-2 text-lg">Şeffaflık</h4>
                        <p class="text-sm text-amber-900/60 leading-relaxed">Bilginin kaynağını hiçbir zaman saklamıyor, her zaman orijinal linki paylaşıyoruz.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trusted Sources Section -->
    <div class="py-24 bg-gray-50/50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">TAKİP ETTİĞİMİZ KURUMLAR</h3>
                <h4 class="text-2xl font-black text-gray-900">Bilgiye Güven Veren Paydaşlarımız</h4>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-x-16 gap-y-10">
                @foreach($trustedSources as $source)
                    @if($source->logo_url)
                        <a href="{{ $source->official_url ?? '#' }}" target="_blank" class="block grayscale opacity-40 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                            <img src="{{ $source->logo_url }}" class="h-10 md:h-12 w-auto object-contain" alt="{{ $source->source_name }} Logo">
                        </a>
                    @else
                        <a href="{{ $source->official_url ?? '#' }}" target="_blank" class="text-xl font-black text-gray-300 hover:text-gray-900 transition-colors uppercase tracking-widest font-sans opacity-60 hover:opacity-100">
                            {{ $source->source_name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8">
        <div class="bg-primary rounded-[3rem] p-12 md:p-20 text-white relative overflow-hidden shadow-2xl shadow-blue-200">
            <div class="relative z-10 text-center max-w-3xl mx-auto">
                <h3 class="italic text-4xl font-black text-white mb-4">Birlikte Daha Güçlüyüz.</h3>
                <p class="text-blue-100 mb-10 max-w-2xl mx-auto text-lg leading-relaxed">
                    ALS yolculuğunda kimse yalnız kalmamalı. Bilgi paylaşarak, araştırarak ve destek olarak bu büyük dayanışmanın bir parçası olun.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('contact') }}" class="bg-white text-primary px-10 py-4 rounded-2xl font-bold hover:bg-blue-50 transition shadow-xl">İletişime Geçin</a>
                    <a href="{{ route('home') }}" class="bg-primary-dark text-white border border-blue-400 px-10 py-4 rounded-2xl font-bold hover:bg-blue-600 transition">Ana Sayfa</a>
                </div>
            </div>
            
            <!-- Decoration -->
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-blue-400 opacity-20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-blue-300 opacity-20 rounded-full blur-3xl pointer-events-none"></div>
        </div>
    </div>
@endsection
