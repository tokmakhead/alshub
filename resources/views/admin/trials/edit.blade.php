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

                        <!-- Hidden Required Fields to prevent loss on save -->
                        <input type="hidden" name="nct_id" value="{{ $trial->nct_id }}">
                        <input type="hidden" name="title" value="{{ $trial->title }}">
                        <input type="hidden" name="phase" value="{{ $trial->phase }}">
                        <input type="hidden" name="recruitment_status" value="{{ $trial->recruitment_status }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Orijinal Veriler (Read Only) -->
                            <div class="space-y-4 border-r pr-8">
                                <h3 class="font-bold border-b pb-2 text-blue-600 uppercase text-xs tracking-wider">Orijinal Kaynak Verisi (CT.gov)</h3>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">NCT ID / Kaynak</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs flex justify-between items-center">
                                        <span>{{ $trial->nct_id }}</span>
                                        <span class="bg-blue-100 text-blue-700 font-bold px-2 py-0.5 rounded-full" style="font-size: 9px;">
                                            {{ $trial->sponsor ?: 'ClinicalTrials.gov' }} (Tier {{ $trial->verification_tier }})
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Orijinal Başlık</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs font-semibold">{{ $trial->title }}</div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Özet / Protokol (EN)</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs h-80 overflow-y-auto leading-relaxed">{{ $trial->summary }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Faz</label>
                                        <div class="p-2 bg-gray-50 border rounded text-xs">{{ $trial->phase ?: 'Belirtilmemiş' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Sponsor</label>
                                        <div class="p-2 bg-gray-50 border rounded text-xs line-clamp-1">{{ $trial->sponsor }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Düzenlenebilir / Onay Verileri -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold text-green-600 uppercase text-xs tracking-wider">Editör Çalışma Alanı</h3>
                                    <button type="button" 
                                            id="ai-btn"
                                            onclick="generateAISummary()" 
                                            style="background-color: #9333ea; color: white; padding: 6px 14px; border-radius: 6px; border: none; font-weight: bold; font-size: 11px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                        🪄 AI İLE HAZIRLA
                                    </button>
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Türkçe Başlık</label>
                                    <input type="text" name="title_tr" value="{{ old('title_tr', $trial->title_tr) }}" class="w-full rounded border-gray-200 text-sm font-bold bg-white mt-1 p-2">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Özet ve Detaylar (TR)</label>
                                    <textarea id="summary_tr" name="summary_tr" rows="20" class="w-full rounded border-gray-200 text-xs leading-loose bg-white mt-1 p-3">{{ $trial->summary_tr }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 border rounded-lg">
                                    <div>
                                        <div class="flex items-center gap-1 mb-1">
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase">Katman (Tier)</label>
                                            <div class="group relative">
                                                <svg class="w-3 h-3 text-gray-300 cursor-help" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                <div class="hidden group-hover:block absolute z-50 w-64 p-3 bg-gray-900 text-white text-[10px] rounded-lg shadow-xl -left-20 bottom-5 leading-relaxed">
                                                    <strong>Tier 1:</strong> Resmi Kaynaklar (CT.gov vb.)<br>
                                                    <strong>Tier 2:</strong> Kurumsal (Hastaneler vb.)
                                                </div>
                                            </div>
                                        </div>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-xs shadow-sm">
                                            <option value="1" {{ $trial->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Resmi Klinik Kaynak</option>
                                            <option value="2" {{ $trial->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Yerel/Hanehalkı Kaynak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Yayın Durumu</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-xs mt-1">
                                            <option value="draft" {{ $trial->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $trial->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $trial->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                            <option value="published" {{ $trial->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-6 flex justify-end gap-3 border-t">
                                    <a href="{{ route('admin.trials.index') }}" class="px-5 py-2 border border-gray-200 rounded text-xs font-bold text-gray-500 hover:bg-gray-50 transition">İPTAL</a>
                                    <button type="submit" class="px-8 py-2 bg-blue-600 text-white rounded text-xs font-black shadow-md hover:bg-blue-700 transition">
                                        DEĞİŞİKLİKLERİ KAYDET
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
        
        fetch('{{ route('admin.trials.ai-summary', $trial) }}', {
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
