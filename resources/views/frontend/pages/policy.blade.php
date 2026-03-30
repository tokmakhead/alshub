@extends('frontend.layout')

@section('title', 'Kaynak ve Gizlilik Politikası - ALSHub')

@section('content')
<div class="min-h-screen pt-32 pb-20 bg-gradient-to-b from-white to-blue-50/30">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in text-balance">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">
                Bilginin Gücü, <span class="text-primary italic text-nowrap">Şeffaflığın Güvencesi</span>
            </h1>
            <p class="text-lg text-gray-500 leading-relaxed font-medium">
                ALSHub üzerindeki her veri, bilimsel dürüstlük ve kullanıcı güvenliği prensipleriyle yönetilir. Verilerimizin kaynağını, işlenme biçimini ve haklarınızı burada bulabilirsiniz.
            </p>
        </div>

        <!-- Principles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <div class="bg-white/60 backdrop-blur-sm p-8 rounded-3xl border border-white shadow-xl shadow-blue-900/5 hover:-translate-y-1 transition-all">
                <div class="w-10 h-10 bg-blue-50 text-primary rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="font-black text-gray-900 mb-2 uppercase text-xs tracking-widest">Şeffaflık</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Tüm verilerimiz orijinal kaynağına atıfta bulunur ve doğrulanabilir linkler içerir.</p>
            </div>
            <div class="bg-white/60 backdrop-blur-sm p-8 rounded-3xl border border-white shadow-xl shadow-blue-900/5 hover:-translate-y-1 transition-all">
                <div class="w-10 h-10 bg-blue-50 text-green-600 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5c-1 3.142-2.3 5.426-4.751 8.357m0 0a13.11 13.11 0 01-2.251-2.714m2.251 2.714L5 19"></path></svg>
                </div>
                <h3 class="font-black text-gray-900 mb-2 uppercase text-xs tracking-widest">Hassasiyet</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Tıbbi terimlerin çevirisinde orijinal anlamına sadık kalınarak azami özen gösterilir.</p>
            </div>
            <div class="bg-white/60 backdrop-blur-sm p-8 rounded-3xl border border-white shadow-xl shadow-blue-900/5 hover:-translate-y-1 transition-all">
                <div class="w-10 h-10 bg-blue-50 text-indigo-600 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="font-black text-gray-900 mb-2 uppercase text-xs tracking-widest">Gizlilik</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Kullanıcı verileriniz KVKK standartlarında korunur ve asla izinsiz paylaşılmaz.</p>
            </div>
            <div class="bg-white/60 backdrop-blur-sm p-8 rounded-3xl border border-white shadow-xl shadow-blue-900/5 hover:-translate-y-1 transition-all">
                <div class="w-10 h-10 bg-blue-50 text-red-600 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="font-black text-gray-900 mb-2 uppercase text-xs tracking-widest">Bağımsızlık</h3>
                <p class="text-xs text-gray-500 leading-relaxed">ALSHub, herhangi bir ilaç firmasından bağımsız, gönüllü bir projedir.</p>
            </div>
        </div>

        <!-- Detailed Policy Sections -->
        <div class="bg-white p-10 md:p-16 rounded-[3rem] shadow-2xl shadow-blue-900/5 border border-gray-100 relative overflow-hidden">
            <!-- Medical Disclaimer Box -->
            <div class="bg-red-50 border border-red-100 p-8 rounded-3xl mb-12 flex items-start gap-6">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex-shrink-0 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-red-900 mb-2 uppercase tracking-tight">Önemli Tıbbi Uyarı (Medical Disclaimer)</h2>
                    <p class="text-sm text-red-800/80 leading-relaxed font-medium">
                        ALSHub bir tıbbi muayene veya danışmanlık platformu değildir. Burada yer alan bilgiler, güncel araştırmaların ve rehberlerin genel bilgilendirme amaçlı özetleridir. Tedavi kararlarınızı her zaman bir nöroloji uzmanı veya ilgili sağlık profesyoneli eşliğinde vermelisiniz.
                    </p>
                </div>
            </div>

            <div class="prose prose-blue max-w-none text-gray-600 space-y-12">
                <!-- Data Sourcing -->
                <section>
                    <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center text-sm">1</span>
                        Veri Kaynakları ve Doğrulama
                    </h2>
                    <p class="leading-relaxed">
                        Sistemimiz, dünya çapında kabul görmüş akademik (<b>PubMed</b>) ve düzenleyici (<b>FDA, EMA</b>) otoriteleri 24 saatte bir otomatik olarak tarar. Bilgiler, yapay zeka tarafından derlendikten sonra, klinik rehberlerin (<b>NICE, EAN</b>) metodolojisi dikkate alınarak kategorize edilir. Her içeriğin altında "Kaynak" bölümünde orijinal yayın linki mevcuttur.
                    </p>
                </section>

                <hr class="border-gray-100">

                <!-- Translation -->
                <section>
                    <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center text-sm">2</span>
                        Çeviri ve Yerelleştirme Yaklaşımı
                    </h2>
                    <p class="leading-relaxed">
                        Tıbbi terimlerin yanlış anlaşılmasını önlemek adına, Türkçeleştirme sürecinde uluslararası tıp terminolojisi ESA (European Society of Anaesthesiology) ve benzeri standartlar rehber alınır. Orijinalliği korumak için, bazı terimlerin İngilizce karşılıkları metin içerisinde parantez içinde belirtilmektedir.
                    </p>
                </section>

                <hr class="border-gray-100">

                <!-- Privacy & Data -->
                <section>
                    <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center text-sm">3</span>
                        Veri Gizliliği (KVKK/GDPR)
                    </h2>
                    <p class="leading-relaxed">
                        İletişim formları aracılığıyla paylaştığınız bilgiler (Ad, E-posta, Mesaj), talebinizin yanıtlanması ve platformun iyileştirilmesi dışında hiçbir amaçla kullanılmaz. Verileriniz, güvenli sunucularımızda şifrelenmiş olarak saklanır. İstediğiniz an verilerinizin silinmesini talep etme hakkınız mevcuttur.
                    </p>
                </section>

                <hr class="border-gray-100">

                <!-- Corrections -->
                <section>
                    <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center text-sm">4</span>
                        Hatalı İçerik ve Düzeltme
                    </h2>
                    <p class="leading-relaxed mb-8">
                        Bilimsel bir hata, yanlış bir çeviri veya eksik bir bilgi fark ederseniz, bunu bize bildirmek ALSHub'ın doğruluğunu korumasına yardımcı olur.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 bg-gray-50 text-primary px-8 py-4 rounded-2xl font-black text-sm hover:bg-primary hover:text-white transition-all group">
                        Bir Hata Bildir
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </section>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="mt-12 text-center text-xs text-gray-400 font-bold uppercase tracking-[0.2em] opacity-50">
            Son Güncelleme: {{ now()->format('d.m.Y') }} • ALSHub Şeffaflık Standartları v2.1
        </p>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
@endsection
