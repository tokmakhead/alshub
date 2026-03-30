@extends('frontend.layout')

@section('title', 'ALS Tanısı: Kritik Bilgiler ve İlk Prosedürler - ALSHub')

@section('content')
<main class="pt-32 pb-20 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-16 space-y-6">
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                ALS Tanısı: <span class="text-slate-800 border-b-4 border-slate-800">İlk Bilgiler ve Prosedürler</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Tanı sonrası yaşanan kritik süreçleri doğru yönetmek, resmi onaylı tedavilere hızla erişmek ve yasal hakları korumak adına hazırlanmış teknik bilgilendirme rehberidir.
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
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">🩺</div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">1. Klinik Durum ve Kabul</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>Tanı anı sarsıcı olabilir, ancak bu sürecin tıbbi olarak yönetilebilir olduğunu bilmek önemlidir. Kendinize ve duygularınızı anlamaya zaman tanıyın.</p>
                        <ul class="list-disc list-inside space-y-2 marker:text-blue-500">
                            <li>Yanlış bilgilerden kaçının, sadece bilimsel ve kanıta dayalı kaynaklara güvenin.</li>
                            <li>Tıbbi süreci nöroloji uzmanınızla şeffaf bir iletişimle yönetin.</li>
                            <li>Hastalığın her bireyde farklı bir seyir izlediğini unutmayın.</li>
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
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">2. Onaylı Tedavi Seçenekleri</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>Etkisi klinik olarak kanıtlanmamış "alternatif" yöntemler yerine, resmi otoritelerce (TİTCK, FDA, EMA) onaylanmış tedavilere odaklanın:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                                <span class="font-bold text-indigo-700">Riluzol:</span> Hastalığın ilerlemesini yavaşlattığı kanıtlanmış temel tedavi (Türkiye'de geri ödeme kapsamındadır).
                            </div>
                            <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                                <span class="font-bold text-blue-700">Bakım Protokolleri:</span> Beslenme, solunum ve fizik tedavi desteği klinik önem taşır.
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
                        <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-2xl">🤝</div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">3. Türkiye ALS-MNH Derneği Bilgisi</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>Yalnız değilsiniz. Türkiye'deki tek resmi ALS derneği olan ALS-MNH Derneği, tıbbi cihaz ve psikososyal destek konularında rehberlik sağlar.</p>
                        <div class="flex flex-col sm:flex-row gap-4 text-sm pt-2">
                            <a href="https://www.als.org.tr" target="_blank" class="inline-flex items-center text-red-600 font-bold hover:underline">
                                <span class="mr-2 text-xl">🌐</span> als.org.tr
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
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">4. Yasal Haklar ve Bürokrasi</h2>
                    </div>
                    <div class="space-y-4 text-slate-600 leading-relaxed text-sm">
                        <p>Bürokratik süreçleri başlatmak, cihaz/ilaç erişimi ve maddi destekler için kritiktir:</p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="text-emerald-500 mt-1">✔️</span>
                                <div><span class="font-bold text-slate-800">Engelli Raporu:</span> En kısa sürede tam teşekküllü bir devlet hastanesinden alınmalıdır.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-emerald-500 mt-1">✔️</span>
                                <div><span class="font-bold text-slate-800">Evde Bakım ve Haklar:</span> Aile ve Sosyal Hizmetler Bakanlığı başvuruları takip edilmelidir.</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 p-10 rounded-[3rem] bg-slate-900 text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10 text-center space-y-6">
                <h3 class="text-2xl font-bold italic text-slate-300">"Tıbbi süreçlerde şeffaflık ve doğru bilgi hayat kurtarır."</h3>
                <p class="text-slate-400 text-sm max-w-xl mx-auto">
                    ALSHub platformu, araştırmaları ve ilaç onay süreçlerini sizin için takip etmeye devam ediyor.
                </p>
                <div class="pt-4 flex justify-center gap-4">
                    <a href="{{ route('contact') }}" class="px-6 py-3 bg-white text-slate-900 rounded-xl font-bold hover:bg-slate-100 transition-all"> Bize Yazın </a>
                    <a href="{{ route('drugs') }}" class="px-6 py-3 border border-slate-700 text-white rounded-xl font-bold hover:bg-slate-800 transition-all"> İlaçları İncele </a>
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
