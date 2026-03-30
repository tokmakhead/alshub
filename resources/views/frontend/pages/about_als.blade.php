@extends('frontend.layout')

@section('title', 'ALS Nedir? Kapsamlı Rehber - ALSHub')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Side Navigation (Sticky) -->
            <aside class="lg:w-1/4">
                <div class="sticky top-32 space-y-2">
                    <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 px-3">İçindekiler</h5>
                    <a href="#tanim" class="block px-4 py-2 text-sm font-medium text-primary bg-blue-50 rounded-xl transition">1. ALS Nedir?</a>
                    <a href="#belirtiler" class="block px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition">2. Belirtiler ve Süreç</a>
                    <a href="#nedenler" class="block px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition">3. Nedenler ve Riskler</a>
                    <a href="#turler" class="block px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition">4. ALS Türleri</a>
                    <a href="#tani" class="block px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition">5. Tanı Süreci</a>
                    <a href="#tedavi" class="block px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition">6. Tedavi ve Yönetim</a>
                    <a href="#yasam" class="block px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition">7. Yaşam Kalitesi</a>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="lg:w-3/4">
                <article class="prose prose-blue max-w-none">
                    
                    <!-- Section: Tanım -->
                    <section id="tanim" class="scroll-mt-32 mb-16">
                        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tight">ALS (Amyotrofik Lateral Skleroz) Nedir?</h1>
                        <p class="text-xl text-gray-600 leading-relaxed font-medium">
                            ALS, beyin ve omurilikteki motor nöronların kaybına yol açan, ilerleyici ve fatal bir nörodejeneratif hastalıktır. 
                            Dünyada genellikle Amerikalı beyzbolcu Lou Gehrig'in adıyla (Lou Gehrig Hastalığı) bilinir. 
                        </p>
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 rounded-[2rem] text-white my-10 shadow-xl shadow-blue-900/10">
                            <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 outline-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Temel Mekanizma
                            </h3>
                            <p class="text-blue-50 leading-relaxed opacity-90">
                                Motor nöronlar, beyninizden kaslarınıza giden elektrik sinyallerini taşıyan "iletişim hatlarıdır". ALS hastalarında bu hücreler ölür ve kaslara sinyal gitmez olur. Sinyal alamayan kaslar kullanılamaz hale gelir, zamanla erir (atrofi) ve durur.
                            </p>
                        </div>
                    </section>

                    <!-- Section: Belirtiler -->
                    <section id="belirtiler" class="scroll-mt-32 mb-16 border-t border-gray-100 pt-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Belirtiler ve Hastalığın Seyri</h2>
                        <p class="mb-10 text-gray-500">ALS belirtileri kişiden kişiye farklılık gösterse de, genellikle kas zayıflığı ile başlar ve zamanla tüm vücuda yayılır.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                                <h4 class="font-bold text-gray-900 mb-2">Erken Dönem İşaretleri</h4>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li>• Kaslarda seğirme (fasikülasyon)</li>
                                    <li>• Kas krampları ve sertliği</li>
                                    <li>• El becerilerinde azalma (düğme ilikleme vb.)</li>
                                    <li>• Sıklıkla takılma veya düşme</li>
                                    <li>• Peltek veya yavaş konuşma</li>
                                </ul>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                                <h4 class="font-bold text-gray-900 mb-2">İlerleyici Belirtiler</h4>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li>• Çiğneme ve yutma güçlüğü (Disfaji)</li>
                                    <li>• Nefes darlığı ve solunum kaslarının kaybı</li>
                                    <li>• Kas kütlesinde belirgin azalma (Atrofi)</li>
                                    <li>• Aşırı salya üretiminde zorlanma</li>
                                    <li>• Refleks değişiklikleri</li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 p-8 rounded-3xl mb-10">
                            <h4 class="text-amber-900 font-bold mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Genellikle Etkilenmeyen Fonksiyonlar
                            </h4>
                            <p class="text-amber-800 text-sm leading-relaxed mb-0">
                                ALS genellikle beş duyuyu (görme, duyma, tat alma, koklama, dokunma) etkilemez. Ayrıca mesane ve bağırsak kontrolü ile göz kasları genellikle hastalığın son evrelerine kadar korunur. Hastaların zihinsel kapasiteleri genellikle etkilenmez, ancak bazı vakalarda frontal-temporal demans görülebilir.
                            </p>
                        </div>
                    </section>

                    <!-- Section: Nedenler -->
                    <section id="nedenler" class="scroll-mt-32 mb-16 border-t border-gray-100 pt-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Nedenler ve Risk Faktörleri</h2>
                        <p class="mb-8">ALS vakalarının yaklaşık %90'ı "sporadik" yani nedeni bilinmeyen vakalardır. Araştırmalar şu faktörlere yoğunlaşmaktadır:</p>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="bg-blue-100 text-primary w-10 h-10 rounded-full flex items-center justify-center shrink-0 font-bold">1</div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Glutamat Dengesizliği</h4>
                                    <p class="text-sm text-gray-600">Hücreler arasında sinyal taşıyan kimyasal bir madde olan glutamatın fazlalığı sinir hücreleri için toksik olabilir.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="bg-blue-100 text-primary w-10 h-10 rounded-full flex items-center justify-center shrink-0 font-bold">2</div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Bağışıklık Sistemi Yanıtları</h4>
                                    <p class="text-sm text-gray-600">Vücudun kendi bağışıklık sisteminin motor nöronlara saldırması (otoimmün tepki) araştırılmaktadır.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="bg-blue-100 text-primary w-10 h-10 rounded-full flex items-center justify-center shrink-0 font-bold">3</div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Çevresel Faktörler</h4>
                                    <p class="text-sm text-gray-600">Belirli kimyasallara maruz kalma, kurşun ve ağır metaller gibi faktörlerin risk teşkil edebileceğine dair kanıtlar bulunmaktadır.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section: Türler -->
                    <section id="turler" class="scroll-mt-32 mb-16 border-t border-gray-100 pt-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">ALS Türleri</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Sporadik ALS</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    En yaygın türdür (%90-95). Ailede hastalık öyküsü yoktur. Dünyanın her yerinde, her yaştan kitleyi etkileyebilir ancak genellikle 40-70 yaşları arasında görülür.
                                </p>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Ailesel (Genetik) ALS</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    Vakaların %5-10'unu oluşturur. Genetik bir mutasyondan kaynaklanır. Anne veya babasında ALS geni bulunan birinin bu geni alma (veya taşınma) olasılığı %50'dir. **SOD1**, **C9orf72** en bilinen mutasyon genleridir.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Section: Tanı -->
                    <section id="tani" class="scroll-mt-32 mb-16 border-t border-gray-100 pt-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Tanı Süreci</h2>
                        <p class="mb-8">ALS tanısı bir "dışlama" (exclusion) tanısıdır. Çünkü belirtileri MS, Lyme hastalığı veya boyun fıtığı ile benzerlik gösterebilir. Tek bir test sonucuyla tanı konulamaz.</p>
                        <div class="bg-gray-50 rounded-[2.5rem] p-10 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-6">Kullanılan Temel Tetkikler:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <div class="text-primary font-black text-xl mb-1 italic">EMG</div>
                                    <p class="text-xs text-gray-500">Kasların elektriksel aktivitesini ölçer. ALS tanısında en kritik testtir.</p>
                                </div>
                                <div>
                                    <div class="text-primary font-black text-xl mb-1 italic">MRI</div>
                                    <p class="text-xs text-gray-500">Beyin ve omurilik görüntülenerek benzer belirtileri verebilecek tümör veya fıtıklar elenir.</p>
                                </div>
                                <div>
                                    <div class="text-primary font-black text-xl mb-1 italic">Lomber Ponksiyon</div>
                                    <p class="text-xs text-gray-500">Omurilik sıvısı (BOS) analizi yapılarak inflamatuar hastalıklar elenir.</p>
                                </div>
                                <div>
                                    <div class="text-primary font-black text-xl mb-1 italic">Kan & İdrar Testleri</div>
                                    <p class="text-xs text-gray-500">Vitamin eksiklikleri veya ağır metal zehirlenmeleri kontrol edilir.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section: Tedavi -->
                    <section id="tedavi" class="scroll-mt-32 mb-16 border-t border-gray-100 pt-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Tedavi ve Yönetim</h2>
                        <p class="mb-10 leading-relaxed">Şu an için ALS'nin kesin bir tedavisi (kür) bulunmamaktadır. Ancak, modern tıp hastalığın hızını yavaşlatmak ve yaşam süresini uzatmak için önemli araçlara sahiptir.</p>
                        
                        <div class="space-y-12">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-primary pl-4">İlaç Tedavileri</h4>
                                <ul class="list-disc pl-5 space-y-4 text-gray-600">
                                    <li><strong>Riluzol (Rilutek):</strong> Glutamat seviyelerini düşürerek sinir hücrelerini korumaya yardımcı olur. Yaşam süresini birkaç ay uzattığı kanıtlanmıştır.</li>
                                    <li><strong>Edaravone (Radicava):</strong> Oksidatif stresi azaltarak günlük fonksiyon kaybını yavaşlatır.</li>
                                    <li><strong>Tofersen (Qalsody):</strong> Yalnızca SOD1 gen mutasyonu olan hastalar için geliştirilmiş yeni bir genetik tedavidir.</li>
                                </ul>
                            </div>
                            
                            <div class="bg-indigo-50 p-8 rounded-3xl">
                                <h4 class="text-indigo-900 font-bold mb-4">Multidisipliner Bakım</h4>
                                <p class="text-indigo-800/80 text-sm mb-0">ALS hastaları için en etkili yaklaşım; nörolog, fizik tedavi uzmanı, konuşma terapisti, beslenme uzmanı ve psikologdan oluşan geniş bir ekibin takibidir. Bu klinikler, hastaların yaşam kalitesini standart bakıma göre %30-40 daha fazla artırmaktadır.</p>
                            </div>
                        </div>
                    </section>

                    <!-- Section: Yaşam Kalitesi -->
                    <section id="yasam" class="scroll-mt-32 mb-20 border-t border-gray-100 pt-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Yaşam Kalitesini Artıran Destekler</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm">
                                <span class="bg-blue-50 text-primary p-3 rounded-2xl block mb-4 w-fit">🌬️ Solunum</span>
                                <p class="text-xs text-gray-500 leading-relaxed">Gece kullanılan küçük maskeler (BiPAP) uyku kalitesini ve enerjiyi artırır.</p>
                            </div>
                            <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm">
                                <span class="bg-blue-50 text-primary p-3 rounded-2xl block mb-4 w-fit">🍲 Beslenme</span>
                                <p class="text-xs text-gray-500 leading-relaxed">Yutma güçleştiğinde, mideden besleme (PEG) yoluyla kilo kaybı ve enfeksiyon önlenebilir.</p>
                            </div>
                            <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm">
                                <span class="bg-blue-50 text-primary p-3 rounded-2xl block mb-4 w-fit">🗣️ İletişim</span>
                                <p class="text-xs text-gray-500 leading-relaxed">Konuşma zorlaştığında, göz takip cihazları (Eye-tracking) hastaların dünyayla bağını korur.</p>
                            </div>
                        </div>
                    </section>

                    <!-- Sources & Disclaimer -->
                    <footer class="mt-20 pt-10 border-t border-gray-200">
                        <div class="space-y-6">
                            <!-- Kaynaklar -->
                            <div class="flex items-start gap-4 bg-blue-50/50 p-6 rounded-3xl">
                                <span class="text-2xl mt-1">📚</span>
                                <div>
                                    <h5 class="text-sm font-bold text-gray-900 mb-1">Kaynaklar</h5>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-0">
                                        ALS Association (USA), Mayo Clinic, NIH (National Institutes of Health), ALS-MNH Derneği (Türkiye).
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Yasal Uyarı -->
                            <div class="flex items-start gap-4 bg-gray-50 p-6 rounded-3xl">
                                <span class="text-2xl mt-1">⚖️</span>
                                <div>
                                    <h5 class="text-sm font-bold text-gray-900 mb-1">Yasal Uyarı</h5>
                                    <p class="text-xs text-gray-500 italic leading-relaxed mb-0">
                                        Bu sayfada yer alan bilgiler yalnızca genel bilgilendirme amaçlıdır ve bir tıp uzmanının görüşü yerine geçmez. Tanı, teşhis ve tedavi süreçleriniz için mutlaka alanında uzman bir nöroloji hekimine başvurunuz.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </footer>

                </article>
            </main>
        </div>
    </div>

    <!-- Active Section Highlighter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('aside a');

            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= sectionTop - 150) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('bg-blue-50', 'text-primary');
                    link.classList.add('text-gray-500');
                    if (link.getAttribute('href').substring(1) === current) {
                        link.classList.add('bg-blue-50', 'text-primary');
                        link.classList.remove('text-gray-500');
                    }
                });
            });
        });
    </script>
@endsection
