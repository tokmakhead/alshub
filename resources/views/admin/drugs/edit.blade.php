<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('İlaç Bilgi Kartı ve Onay Yönetimi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.drugs.update', $drug) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-sm">
                            <!-- Sol Kolon: Ana Veriler -->
                            <div class="lg:col-span-2 space-y-6">
                                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 leading-none">Temel İlaç Kimliği</h3>
                                            <p class="text-[11px] text-gray-400 mt-1 uppercase font-black tracking-wider">İlacın etken maddesi ve piyasa adı</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="flex items-center gap-2 text-[11px] font-black text-gray-400 uppercase mb-2 tracking-widest leading-none">
                                                Generic Adı (Etken Madde)
                                                <span class="text-blue-500 cursor-help" title="İlacın bilimsel adı (Örn: Edaravone)">ⓘ</span>
                                            </label>
                                            <input type="text" name="generic_name" value="{{ $drug->generic_name }}" class="w-full rounded-2xl border-gray-100 bg-gray-50/50 py-3 text-sm font-bold focus:ring-blue-500 focus:border-blue-500 @if(str_contains($drug->generic_name, 'INDICATIONS')) border-red-300 ring-2 ring-red-50 @endif">
                                            @if(str_contains($drug->generic_name, 'INDICATIONS'))
                                                <p class="text-[10px] text-red-500 mt-2 font-bold italic">⚠️ Not: Bu alan kirli veri içeriyor olabilir (Göstergeler/Cümleler). Lütfen sadece etken madde adını bırakın.</p>
                                            @endif
                                        </div>
                                        <div>
                                            <label class="flex items-center gap-2 text-[11px] font-black text-gray-400 uppercase mb-2 tracking-widest leading-none">
                                                Ticari Adı (Piyasa Adı)
                                                <span class="text-blue-500 cursor-help" title="İlacın kutu üzerindeki adı (Örn: Radicava)">ⓘ</span>
                                            </label>
                                            <input type="text" name="brand_name" value="{{ $drug->brand_name }}" placeholder="Piyasa adı girin..." class="w-full rounded-2xl border-gray-100 bg-gray-50/50 py-3 text-sm font-bold focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="flex items-center gap-2 text-[11px] font-black text-gray-400 uppercase mb-2 tracking-widest leading-none">
                                                Endikasyon / Hedef Mekanizma
                                                <span class="text-blue-500 cursor-help" title="Bu ilaç neyi hedefliyor veya hangi sorunu çözüyor?">ⓘ</span>
                                            </label>
                                            <input type="text" name="indication" value="{{ $drug->indication }}" placeholder="Örn: ALS'de fonksiyonel kapasite kaybının yavaşlatılması" class="w-full rounded-2xl border-gray-100 bg-gray-50/50 py-3 text-sm font-bold focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden">
                                     <div class="flex justify-between items-center mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 leading-none">Türkçe İçerik ve AI Analizi</h3>
                                                <p class="text-[11px] text-gray-400 mt-1 uppercase font-black tracking-wider">Otomatik özetleme ve çeviri araçları</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="generateSummary()" id="ai-btn" class="bg-gray-900 text-white px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all flex items-center gap-2 shadow-xl shadow-gray-200">
                                            <span id="ai-text">🪄 AI İLE ANALİZ ET</span>
                                            <svg id="ai-spinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </button>
                                    </div>
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-[11px] font-black text-gray-400 uppercase mb-2 tracking-widest leading-none">Kaynak Veri (İngilizce Orijinal)</label>
                                            <textarea name="description_original" rows="4" class="w-full rounded-2xl border-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 p-4">{{ $drug->description_original }}</textarea>
                                            <p class="text-[10px] text-gray-400 mt-2 italic font-medium">Bu veri AI özetleme için temel teşkil eder. Değiştirmeniz önerilmez.</p>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-black text-gray-400 uppercase mb-2 tracking-widest leading-none">Türkçe Özet & Analiz (Hastalar İçin)</label>
                                            <textarea name="description_tr" rows="8" class="w-full rounded-2xl border-gray-100 text-sm font-medium focus:ring-blue-500 focus:border-blue-500 p-4 leading-relaxed">{{ $drug->description_tr }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6">
                                    <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-50 border-dashed">
                                        <h4 class="font-bold text-gray-800 mb-4 text-xs uppercase tracking-widest">💰 Finansal & Erişim</h4>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Maliyet / Fiyatlandırma</label>
                                                <input type="text" name="price_info" value="{{ $drug->price_info }}" class="w-full rounded-xl border-gray-100 text-xs font-bold bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Türkiye Erişimi</label>
                                                <input type="text" name="accessibility_info" value="{{ $drug->accessibility_info }}" class="w-full rounded-xl border-gray-100 text-xs font-bold bg-white">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-50 border-dashed">
                                        <h4 class="font-bold text-gray-800 mb-4 text-xs uppercase tracking-widest">🔗 Regülatör Linkleri</h4>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 text-blue-500">FDA Official Link</label>
                                                <input type="url" name="fda_link" value="{{ $drug->fda_link }}" class="w-full rounded-xl border-gray-100 text-xs font-bold bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 text-indigo-500">EMA Official Link</label>
                                                <input type="url" name="ema_link" value="{{ $drug->ema_link }}" class="w-full rounded-xl border-gray-100 text-xs font-bold bg-white">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sağ Kolon: Durum ve Onaylar -->
                            <div class="space-y-6">
                                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-100 sticky top-6">
                                    <h3 class="font-bold text-gray-900 mb-8 flex items-center gap-3 border-b border-gray-50 pb-6">
                                        <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        Yayın Yönetimi
                                    </h3>

                                    <div class="space-y-8">
                                        <div>
                                            <label class="block text-[11px] font-black text-gray-400 uppercase mb-3 tracking-widest">Güven Seviyesi (Tier)</label>
                                            <select name="verification_tier" class="w-full rounded-2xl border-gray-100 bg-gray-50/50 py-3 font-bold text-xs ring-0 focus:ring-blue-500 mt-1">
                                                <option value="1" {{ $drug->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Regulator Verified</option>
                                                <option value="2" {{ $drug->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Scientific Peer Review</option>
                                                <option value="3" {{ $drug->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Preliminary Data</option>
                                            </select>
                                            <p class="text-[10px] text-gray-400 mt-2 leading-relaxed italic">Verinin güvenilirliğini belirler (Tier 1 en yüksek).</p>
                                        </div>

                                        <div>
                                            <label class="block text-[11px] font-black text-gray-400 uppercase mb-3 tracking-widest">Kontrol Durumu</label>
                                            <select name="status" class="w-full rounded-2xl border-gray-100 bg-gray-50/50 py-3 font-bold text-xs ring-0 focus:ring-blue-500 mt-1">
                                                <option value="draft" {{ $drug->status == 'draft' ? 'selected' : '' }}>TASLAK (Düzenleniyor)</option>
                                                <option value="in_review" {{ $drug->status == 'in_review' ? 'selected' : '' }}>İNCELEMEDE (Yayına Hazır)</option>
                                                <option value="approved" {{ $drug->status == 'approved' ? 'selected' : '' }}>ONAYLANDI (Yayına Girebilir)</option>
                                                <option value="published" {{ $drug->status == 'published' ? 'selected' : '' }}>YAYINDA (Herkes Görebilir)</option>
                                                <option value="rejected" {{ $drug->status == 'rejected' ? 'selected' : '' }}>REDDEDİLDİ</option>
                                            </select>
                                        </div>

                                        <div class="space-y-4 pt-4 border-t border-gray-50">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Onay Rozetleri</p>
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_fda" value="1" {{ $drug->is_approved_fda ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-gray-200 text-blue-600 focus:ring-blue-500">
                                                <span class="text-xs font-black text-gray-600 group-hover:text-blue-600 transition-colors uppercase tracking-wider">FDA Onayı Var</span>
                                            </label>
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_ema" value="1" {{ $drug->is_approved_ema ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-gray-200 text-indigo-600 focus:ring-indigo-500">
                                                <span class="text-xs font-black text-gray-600 group-hover:text-indigo-600 transition-colors uppercase tracking-wider">EMA Onayı Var</span>
                                            </label>
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_titck" value="1" {{ $drug->is_approved_titck ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-gray-200 text-red-600 focus:ring-red-500">
                                                <span class="text-xs font-black text-gray-600 group-hover:text-red-600 transition-colors uppercase tracking-wider">TİTCK Onayı Var</span>
                                            </label>
                                        </div>

                                        <div class="pt-8">
                                            <button type="submit" class="w-full bg-blue-600 text-white rounded-2xl py-5 font-black uppercase tracking-[0.2em] text-[10px] hover:bg-blue-700 shadow-xl shadow-blue-100 hover:scale-[1.02] transition-all">
                                                GÜNCELLE VE KAYDET
                                            </button>
                                            <a href="{{ route('admin.drugs.index') }}" class="block text-center mt-6 text-[10px] font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest">← LİSTEYE GERİ DÖN</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                    function generateSummary() {
                        const btn = document.getElementById('ai-btn');
                        const text = document.getElementById('ai-text');
                        const spinner = document.getElementById('ai-spinner');
                        
                        btn.disabled = true;
                        text.innerText = 'HAZIRLANIYOR...';
                        spinner.classList.remove('hidden');

                        fetch('{{ route("admin.drugs.ai-summary", $drug) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert('AI Hatası: ' + data.message);
                            }
                        })
                        .catch(error => {
                            alert('Bir hata oluştu: ' + error);
                        })
                        .finally(() => {
                            btn.disabled = false;
                            text.innerText = '🪄 AI İLE ANALİZ ET';
                            spinner.classList.add('hidden');
                        });
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
