@extends('frontend.layout')

@section('title', 'ALS Tanı Sonrası İlk Adımlar ve Bilgilendirme Rehberi - ALSHub')

@section('content')
<main class="pt-32 pb-20 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-16 space-y-6">
            <div class="inline-flex items-center px-4 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-widest border border-slate-200">
                TANI SONRASI BİLGİLENDİRME
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Tanıdan Sonra <span class="text-slate-800 border-b-4 border-slate-800">Yapılması Gerekenler</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Tanı sonrası yaşanan kritik süreçleri doğru yönetmek, resmi onaylı tedavilere hızla erişmek ve yasal hakları korumak adına teknik ve tıbbi rehberdir.
            </p>
        </div>

        <!-- Steps Content -->
        <div class="space-y-8">
            
            <!-- Item 1: Tıbbi Bilgilendirme -->
            <div class="bg-white border border-slate-200 p-8 rounded-3xl shadow-sm hover:border-slate-300 transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-900 flex items-center justify-center text-white font-bold text-sm">01</div>
                    <h2 class="text-xl font-bold text-slate-900 uppercase tracking-tight">Klinik Durum ve Bilimsel Yaklaşım</h2>
                </div>
                <div class="space-y-4 text-slate-600 leading-relaxed text-sm">
                    <p>ALS, motor nöronların kaybıyla ilerleyen nörodejeneratif bir hastalıktır. Bu süreçte en önemli kural, manipülasyona açık "alternatif" vaatlerden kaçınarak tıbbi protokollere sadık kalmaktır.</p>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <li class="p-4 bg-slate-50 rounded-2xl border border-slate-100">Gerçekçi beklentiler oluşturun.</li>
                        <li class="p-4 bg-slate-50 rounded-2xl border border-slate-100">Tıbbi süreci nöroloji uzmanınızla yönetin.</li>
                    </ul>
                </div>
            </div>

            <!-- Item 2: İlaç ve Tedavi -->
            <div class="bg-white border border-slate-200 p-8 rounded-3xl shadow-sm hover:border-slate-300 transition-all border-l-4 border-l-slate-800">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-900 flex items-center justify-center text-white font-bold text-sm">02</div>
                    <h2 class="text-xl font-bold text-slate-900 uppercase tracking-tight">Resmi Onaylı Tedavi Seçenekleri</h2>
                </div>
                <div class="space-y-4 text-slate-600 leading-relaxed text-sm">
                    <p>Şu an için onaylanmış tedaviler hastalığın seyrini yavaşlatmaya yöneliktir:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="font-bold block mb-1">Riluzol:</span> Türkiye'de geri ödeme kapsamında olan temel klinik tedavi.
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="font-bold block mb-1">Bakım Protokolleri:</span> Beslenme, solunum ve fizik tedavi desteği kritik önem taşır.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 3: Dernek ve Destek -->
            <div class="bg-white border border-slate-200 p-8 rounded-3xl shadow-sm hover:border-slate-300 transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-900 flex items-center justify-center text-white font-bold text-sm">03</div>
                    <h2 class="text-xl font-bold text-slate-900 uppercase tracking-tight">Türkiye ALS-MNH Derneği İletişimi</h2>
                </div>
                <div class="space-y-4 text-slate-600 leading-relaxed text-sm">
                    <p>Hastalara tıbbi cihaz, malzeme desteği ve rehberlik sağlayan resmi yapıdır. İlgili birimlerle iletişime geçmek süreç yönetimini kolaylaştırır.</p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="https://www.als.org.tr" target="_blank" class="px-5 py-2.5 bg-slate-100 text-slate-900 text-sm font-bold rounded-xl hover:bg-slate-200 transition-all border border-slate-200">
                            Resmi Web Sitesi
                        </a>
                        <a href="tel:+902125595919" class="px-5 py-2.5 bg-slate-100 text-slate-900 text-sm font-bold rounded-xl hover:bg-slate-200 transition-all border border-slate-200">
                            0212 559 59 19
                        </a>
                    </div>
                </div>
            </div>

            <!-- Item 4: Yasal Haklar -->
            <div class="bg-white border border-slate-200 p-8 rounded-3xl shadow-sm hover:border-slate-300 transition-all border-l-4 border-l-slate-800">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-900 flex items-center justify-center text-white font-bold text-sm">04</div>
                    <h2 class="text-xl font-bold text-slate-900 uppercase tracking-tight">Yasal Süreç ve Hakların Takibi</h2>
                </div>
                <div class="space-y-5 text-slate-600 leading-relaxed text-sm">
                    <p>Bürokratik işlemlerin zamanında tamamlanması, cihaz ve ilaç erişimi açısından kritiktir:</p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-900 mt-2 shrink-0"></span>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1 leading-none">Engelli Sağlık Kurulu Raporu</h4>
                                <p class="text-slate-500">Cihaz, ilaç ve vergi indirimleri için tam teşekküllü bir devlet hastanesinden hızla alınmalıdır.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-900 mt-2 shrink-0"></span>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1 leading-none">Evde Bakım ve Maddi Destekler</h4>
                                <p class="text-slate-500">Şartların uygunluğu halinde Aile ve Sosyal Hizmetler Bakanlığı başvuruları başlatılmalıdır.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center text-slate-400 text-xs font-medium uppercase tracking-widest">
            Tüm içerikler tıbbi genel bilgilendirme amaçlıdır. Nihai karar takip eden uzman doktora aittir.
        </div>
    </div>
</main>
@endsection
