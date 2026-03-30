@extends('frontend.layout')

@section('title', 'ALS Yolculuğunda İlk Adımlar: Yeni Tanı Alanlar İçin Rehber - ALSHub')

@section('content')
<main class="pt-32 pb-20 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-16 space-y-4">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-sm font-bold tracking-wide border border-blue-100 shadow-sm animate-fade-in">
                <span class="mr-2">✨</span> YENİ TANI ALANLAR İÇİN REHBER
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                ALS Yolculuğunda <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">İlk Adımlar</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Tanı sonrası yaşanan karmaşa ve belirsizliği sükunetle aşmanıza yardımcı olmak için hazırladığımız, güvenilir ve adım adım ilerleyen yol haritası.
            </p>
        </div>

        <!-- Steps Timeline -->
        <div class="relative space-y-12">
            <!-- Vertical Line -->
            <div class="absolute left-0 md:left-8 top-8 bottom-8 w-px bg-gradient-to-b from-blue-200 via-indigo-100 to-transparent hidden md:block"></div>

            <!-- Step 1: Sakinlik -->
            <div class="relative pl-0 md:pl-20 group">
                <div class="absolute left-0 md:left-4 top-0 w-8 h-8 rounded-full bg-white border-4 border-blue-600 shadow-lg z-10 hidden md:flex items-center justify-center transition-transform group-hover:scale-110"></div>
                <div class="bg-white/70 backdrop-blur-xl border border-white/50 p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(15,76,129,0.05)] hover:shadow-[0_20px_50px_rgba(15,76,129,0.1)] transition-all duration-500">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">🧘‍♂️</div>
                        <h2 class="text-2xl font-black text-slate-900">1. Sakin Olun ve Kabullenin</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>Tanı anı şok edici olabilir, ancak bu sürecin kontrol edilebilir olduğunu bilmek önemlidir. Kendinize ve duygularınıza zaman tanıyın.</p>
                        <ul class="list-disc list-inside space-y-2 marker:text-blue-500">
                            <li>Yanlış bilgilerden kaçının, sadece bilimsel kaynaklara güvenin.</li>
                            <li>Duygularınızı bastırmayın, yakınlarınızla paylaşın.</li>
                            <li>Hastalığın her bireyde farklı seyrettiğini unutmayın.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Step 2: Resmi Onaylı Tedaviler -->
            <div class="relative pl-0 md:pl-20 group">
                <div class="absolute left-0 md:left-4 top-0 w-8 h-8 rounded-full bg-white border-4 border-indigo-600 shadow-lg z-10 hidden md:flex items-center justify-center transition-transform group-hover:scale-110"></div>
                <div class="bg-white/70 backdrop-blur-xl border border-white/50 p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(15,76,129,0.05)] hover:shadow-[0_20px_50px_rgba(15,76,129,0.1)] transition-all duration-500 border-l-4 border-l-indigo-500">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-2xl">💊</div>
                        <h2 class="text-2xl font-black text-slate-900">2. Tıbbi Onaylı Tedavi Seçenekleri</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>Mucizevi çözümler vaat eden "alternatif" yöntemler yerine, etkisi kanıtlanmış tedavilere odaklanın:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                                <span class="font-bold text-indigo-700">Riluzol:</span> Hastalığın ilerlemesini yavaşlattığı kanıtlanmış temel tedavi (Türkiye'de geri ödeme kapsamındadır).
                            </div>
                            <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                                <span class="font-bold text-blue-700">Bakım Protokolleri:</span> Beslenme, solunum ve fizik tedavi desteği yaşam süresini en az ilaçlar kadar uzatır.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: ALS-MNH Derneği -->
            <div class="relative pl-0 md:pl-20 group">
                <div class="absolute left-0 md:left-4 top-0 w-8 h-8 rounded-full bg-white border-4 border-red-600 shadow-lg z-10 hidden md:flex items-center justify-center transition-transform group-hover:scale-110"></div>
                <div class="bg-white/70 backdrop-blur-xl border border-white/50 p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(15,76,129,0.05)] hover:shadow-[0_20px_50px_rgba(15,76,129,0.1)] transition-all duration-500 border-l-4 border-l-red-500">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-2xl">🚨</div>
                        <h2 class="text-2xl font-black text-slate-900">3. Türkiye ALS-MNH Derneği ile Tanışın</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>Yalnız değilsiniz. Türkiye'deki en güçlü dayanışma ağı olan ALS-MNH Derneği, hem tıbbi cihaz hem de psikososyal destek sağlar.</p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="https://www.als.org.tr" target="_blank" class="inline-flex items-center text-red-600 font-bold hover:underline">
                                <span class="mr-2 text-xl">🌐</span> Resmi Web Sitesi
                            </a>
                            <span class="hidden sm:block text-slate-300">|</span>
                            <a href="tel:+902125595919" class="inline-flex items-center text-red-600 font-bold hover:underline">
                                <span class="mr-2 text-xl">📞</span> 0212 559 59 19
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Yasal Haklar -->
            <div class="relative pl-0 md:pl-20 group">
                <div class="absolute left-0 md:left-4 top-0 w-8 h-8 rounded-full bg-white border-4 border-emerald-600 shadow-lg z-10 hidden md:flex items-center justify-center transition-transform group-hover:scale-110"></div>
                <div class="bg-white/70 backdrop-blur-xl border border-white/50 p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(15,76,129,0.05)] hover:shadow-[0_20px_50px_rgba(15,76,129,0.1)] transition-all duration-500 border-l-4 border-l-emerald-500">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-2xl">⚖️</div>
                        <h2 class="text-2xl font-black text-slate-900">4. Yasal Haklarınızı Koruyun</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>Tanı sonrası bürokratik süreci başlatmak, cihaz ve ilaç erişimi ile maddi destekler için kritiktir:</p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="text-emerald-500 mt-1">✔️</span>
                                <div><span class="font-bold text-slate-800">Engelli Sağlık Kurulu Raporu:</span> En kısa sürede tam teşekküllü bir devlet hastanesinden alınmalıdır.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-emerald-500 mt-1">✔️</span>
                                <div><span class="font-bold text-slate-800">Evde Bakım Desteği:</span> Şartların sağlanması durumunda Aile ve Sosyal Hizmetler Bakanlığı'na başvurulabilir.</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-20 p-10 rounded-[3rem] bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
            <div class="relative z-10 text-center space-y-6">
                <h3 class="text-3xl font-black italic">"Bu yolda asla yalnız değilsiniz."</h3>
                <p class="text-blue-100 text-lg max-w-xl mx-auto font-medium">
                    ALS Hub platformu, en yeni araştırmaları ve ilaç onay süreçlerini şeffaf bir şekilde sizin için takip etmeye devam ediyor.
                </p>
                <div class="pt-4 flex justify-center gap-4">
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-blue-600 rounded-2xl font-black hover:bg-blue-50 transition-all shadow-xl shadow-blue-900/20 active:scale-95"> Bize Soru Sorun </a>
                    <a href="{{ route('drugs') }}" class="px-8 py-4 bg-blue-500 text-white border border-blue-400 rounded-2xl font-black hover:bg-blue-400 transition-all active:scale-95"> İlaçları İncele </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('styles')
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
    }
</style>
@endsection
