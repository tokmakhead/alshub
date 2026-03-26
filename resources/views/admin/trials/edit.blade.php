<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klinik Çalışma İnceleme ve Onay') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.trials.update', $trial) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Orijinal Veriler (Read Only) -->
                            <div class="space-y-4 border-r pr-6">
                                <h3 class="font-bold border-b pb-2 text-blue-600">Orijinal Kaynak Verisi (CT.gov)</h3>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">NCT ID</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm">{{ $trial->nct_id }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Başlık</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm">{{ $trial->title }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Özet / Protokol</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs h-40 overflow-y-auto">{{ $trial->summary }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Faz</label>
                                        <div class="p-2 bg-gray-50 border rounded text-sm">{{ $trial->phase }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Sponsor</label>
                                        <div class="p-2 bg-gray-50 border rounded text-sm">{{ $trial->sponsor }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Düzenlenebilir / Onay Verileri -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold text-green-600">Editör Çalışma Alanı (Türkçe Çeviri/Özet)</h3>
                                    <button type="button" 
                                            id="ai-btn"
                                            onclick="generateAISummary()" 
                                            style="background-color: #9333ea; color: white; padding: 6px 14px; border-radius: 6px; border: none; font-weight: bold; font-size: 11px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                        🪄 AI İLE HAZIRLA
                                    </button>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Özet ve Detaylar</label>
                                    <textarea id="summary_tr" name="summary" rows="15" class="w-full rounded border-gray-300 text-sm p-3 leading-relaxed">{{ $trial->summary }}</textarea>
                                </div>

                                <script>
                                    function generateAISummary() {
                                        const btn = document.getElementById('ai-btn');
                                        if (!btn) return;
                                        
                                        const oldHtml = btn.innerHTML;
                                        btn.disabled = true;
                                        btn.innerText = 'HAZIRLANIYOR...';
                                        
                                        fetch('{{ route('admin.trials.ai-summary', $trial) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json'
                                            }
                                        })
                                        .then(async response => {
                                            const data = await response.json();
                                            if(data.success) {
                                                location.reload();
                                            } else {
                                                throw new Error(data.message || 'Bilinmeyen hata');
                                            }
                                        })
                                        .catch(err => {
                                            alert('Hata: ' + err.message);
                                            btn.disabled = false;
                                            btn.innerHTML = oldHtml;
                                        });
                                    }
                                </script>
                               <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Doğrulama Katmanı (Tier)</label>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-sm">
                                            <option value="1" {{ $trial->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Official Trial</option>
                                            <option value="2" {{ $trial->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Hospital Trial</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Yayın Durumu</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-sm">
                                            <option value="draft" {{ $trial->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $trial->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $trial->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                            <option value="published" {{ $trial->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2">
                                    <a href="{{ route('admin.trials.index') }}" class="px-4 py-2 border rounded text-sm hover:bg-gray-50">İptal</a>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-700">Onay Durumunu Güncelle</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
