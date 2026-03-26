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

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Sol Kolon: Ana Veriler -->
                            <div class="lg:col-span-2 space-y-6">
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Temel İlaç Kimliği
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-1">Generic Adı (Etken Madde)</label>
                                            <input type="text" name="generic_name" value="{{ $drug->generic_name }}" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-1">Ticari Adı (Brand)</label>
                                            <input type="text" name="brand_name" value="{{ $drug->brand_name }}" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-1">Endikasyon / Hedef</label>
                                            <input type="text" name="indication" value="{{ $drug->indication }}" placeholder="Örn: ALS'de fonksiyonel kapasite kaybının yavaşlatılması" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary">
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
                                     <div class="flex justify-between items-center mb-4">
                                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Modernleştirilmiş Türkçe İçerik (AI)
                                        </h3>
                                        <button type="button" onclick="generateSummary()" id="ai-btn" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:shadow-lg transition-all flex items-center gap-2">
                                            <span id="ai-text">🪄 AI İLE HAZIRLA</span>
                                            <svg id="ai-spinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-2">Orijinal Açıklama (İngilizce)</label>
                                            <textarea name="description_original" rows="6" class="w-full rounded-xl border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50">{{ $drug->description_original }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-2">Türkçe Özet & Analiz (Hastalar İçin)</label>
                                            <textarea name="description_tr" rows="10" class="w-full rounded-xl border-gray-200 text-sm focus:ring-primary focus:border-primary">{{ $drug->description_tr }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                        <h4 class="font-bold text-gray-800 mb-3 text-sm">Finansal & Erişim Bilgileri</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase">Fiyatlandırma Notu</label>
                                                <input type="text" name="price_info" value="{{ $drug->price_info }}" class="w-full rounded-lg border-gray-200 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase">Erişilebilirlik (Türkiye)</label>
                                                <input type="text" name="accessibility_info" value="{{ $drug->accessibility_info }}" class="w-full rounded-lg border-gray-200 text-xs">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                        <h4 class="font-bold text-gray-800 mb-3 text-sm">Regülatör Bağlantıları</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase">FDA Link</label>
                                                <input type="url" name="fda_link" value="{{ $drug->fda_link }}" class="w-full rounded-lg border-gray-200 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase">EMA Link</label>
                                                <input type="url" name="ema_link" value="{{ $drug->ema_link }}" class="w-full rounded-lg border-gray-200 text-xs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sağ Kolon: Durum ve Onaylar -->
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                                    <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Yayın ve Kalite Kontrol
                                    </h3>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-2">Güven Katmanı (Tier)</label>
                                            <select name="verification_tier" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-sm">
                                                <option value="1" {{ $drug->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Regulator Verified</option>
                                                <option value="2" {{ $drug->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Scientific Peer Review</option>
                                                <option value="3" {{ $drug->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Preliminary Data</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-2">Yayın Durumu</label>
                                            <select name="status" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-sm">
                                                <option value="draft" {{ $drug->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                                <option value="in_review" {{ $drug->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                                <option value="approved" {{ $drug->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                                <option value="published" {{ $drug->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                                <option value="rejected" {{ $drug->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                            </select>
                                        </div>

                                        <div class="space-y-3 pt-4 border-t border-gray-100">
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_fda" value="1" {{ $drug->is_approved_fda ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span class="text-sm font-bold text-gray-700 group-hover:text-blue-600 transition-colors uppercase">FDA Onaylı</span>
                                            </label>
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_ema" value="1" {{ $drug->is_approved_ema ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <span class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition-colors uppercase">EMA Onaylı</span>
                                            </label>
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_titck" value="1" {{ $drug->is_approved_titck ? 'checked' : '' }} class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                <span class="text-sm font-bold text-gray-700 group-hover:text-red-600 transition-colors uppercase">TİTCK Onaylı (Türkiye)</span>
                                            </label>
                                        </div>

                                        <div class="pt-6">
                                            <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-4 font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg transition-all">
                                                GÜNCELLE VE KAYDET
                                            </button>
                                            <a href="{{ route('admin.drugs.index') }}" class="block text-center mt-4 text-xs font-bold text-gray-400 hover:text-gray-600 uppercase">Listeye Geri Dön</a>
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
                            text.innerText = '🪄 AI İLE HAZIRLA';
                            spinner.classList.add('hidden');
                        });
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
