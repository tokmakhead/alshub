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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Sol Kolon: Orijinal Veriler (Read Only Görünümlü) -->
                            <div class="space-y-4 border-r pr-8">
                                <h3 class="font-bold border-b pb-2 text-blue-600 uppercase text-xs tracking-wider">Orijinal Kaynak Verisi (EN)</h3>
                                
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Generic Adı (Etken Madde)</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs font-semibold">{{ $drug->generic_name }}</div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Orijinal Açıklama (Kaynak)</label>
                                    <textarea readonly class="w-full p-3 bg-gray-50 border rounded text-xs h-[500px] leading-relaxed resize-none focus:ring-0 focus:border-gray-200">{{ $drug->description_original }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Ticari Adı</label>
                                        <div class="p-2 bg-gray-50 border rounded text-xs line-clamp-1">{{ $drug->brand_name ?: 'Belirtilmemiş' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">FDA Link</label>
                                        <div class="p-2 bg-gray-50 border rounded text-xs truncate">{{ $drug->fda_link ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Düzenlenebilir / Onay Verileri (Sağ Kolon) -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold text-green-600 uppercase text-xs tracking-wider">Düzenleme ve Türkçe Analiz</h3>
                                    <button type="button" 
                                            id="ai-btn"
                                            onclick="generateAISummary()" 
                                            style="background-color: #9333ea; color: white; padding: 6px 14px; border-radius: 6px; border: none; font-weight: bold; font-size: 11px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                        🪄 AI İLE HAZIRLA
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase">Generic Adı (Düzeltme)</label>
                                        <input type="text" name="generic_name" value="{{ old('generic_name', $drug->generic_name) }}" class="w-full rounded border-gray-200 text-sm font-bold bg-white mt-1 p-2">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase">Ticari Adı (Brand)</label>
                                        <input type="text" name="brand_name" value="{{ old('brand_name', $drug->brand_name) }}" class="w-full rounded border-gray-200 text-sm font-bold bg-white mt-1 p-2">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Endikasyon / Hedef</label>
                                    <input type="text" name="indication" value="{{ old('indication', $drug->indication) }}" placeholder="Örn: ALS'de fonksiyonel kapasite kaybı..." class="w-full rounded border-gray-200 text-sm font-bold bg-white mt-1 p-2">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Türkçe Özet & Analiz (Hastalar İçin)</label>
                                    <textarea id="description_tr" name="description_tr" rows="18" class="w-full rounded border-gray-200 text-sm leading-relaxed bg-white mt-1 p-3">{{ $drug->description_tr }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 border rounded-lg">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Güven Katmanı (Tier)</label>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-xs mt-1">
                                            <option value="1" {{ $drug->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Regulator Verified</option>
                                            <option value="2" {{ $drug->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Scientific Peer Review</option>
                                            <option value="3" {{ $drug->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Preliminary Data</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Yayın Durumu</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-xs mt-1">
                                            <option value="draft" {{ $drug->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $drug->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $drug->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                            <option value="published" {{ $drug->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                            <option value="rejected" {{ $drug->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2 space-y-2 pt-2 border-t mt-2">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="is_approved_fda" value="1" {{ $drug->is_approved_fda ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-[10px] font-black uppercase text-gray-600">FDA Onaylı</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="is_approved_ema" value="1" {{ $drug->is_approved_ema ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-[10px] font-black uppercase text-gray-600">EMA Onaylı</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="is_approved_titck" value="1" {{ $drug->is_approved_titck ? 'checked' : '' }} class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                            <span class="text-[10px] font-black uppercase text-gray-600">TİTCK Onaylı (Türkiye)</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-6 flex justify-end gap-3 border-t">
                                    <a href="{{ route('admin.drugs.index') }}" class="px-5 py-2 border border-gray-200 rounded text-xs font-bold text-gray-500 hover:bg-gray-50 transition uppercase">İptal</a>
                                    <button type="submit" class="px-8 py-2 bg-blue-600 text-white rounded text-xs font-black shadow-md hover:bg-blue-700 transition uppercase">
                                        Değişiklikleri Kaydet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function generateAISummary() {
        const btn = document.getElementById('ai-btn');
        if (!btn) return;
        const oldHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerText = 'HAZIRLANIYOR...';
        
        fetch('{{ route("admin.drugs.ai-summary", $drug) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(async r => {
            const data = await r.json();
            if(data.success) {
                window.location.reload();
            } else {
                throw new Error(data.message || 'Hata oluştu');
            }
        })
        .catch(e => {
            alert('Hata: ' + e.message);
            btn.disabled = false;
            btn.innerHTML = oldHtml;
        });
    }
    </script>
</x-app-layout>
