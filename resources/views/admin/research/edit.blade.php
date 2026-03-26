<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Makale İnceleme ve Onay') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.research.update', $article) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- SOL KOLON: Orijinal Veriler (Read Only) -->
                            <div class="space-y-4 border-r pr-6">
                                <h3 class="font-bold border-b pb-2 text-blue-600">Orijinal Kaynak Verisi (PubMed)</h3>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">PMID</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm">{{ $article->pmid }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Başlık</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm font-semibold text-gray-800">{{ $article->title }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Abstract (EN)</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs h-64 overflow-y-auto leading-relaxed">{{ $article->abstract_original }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Dergi / Tarih</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm">
                                        {{ $article->journal }} 
                                        @if($article->publication_date)
                                            ({{ $article->publication_date->format('d.m.Y') }})
                                        @endif
                                    </div>
                                </div>
                                @if($article->doi)
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">DOI</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs text-gray-600 truncate">{{ $article->doi }}</div>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Authors (Yazarlar)</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs text-gray-600 overflow-y-auto max-h-20">
                                        {{ is_array($article->authors_json) ? implode(', ', $article->authors_json) : ($article->authors_json ?: 'Bilinmiyor') }}
                                    </div>
                                </div>
                                @if($article->pmid)
                                <div class="pt-2">
                                    <a href="https://pubmed.ncbi.nlm.nih.gov/{{ $article->pmid }}/" target="_blank" class="text-xs bg-gray-200 px-2 py-1 rounded hover:bg-gray-300 transition">PubMed Adresinde Gör ↗</a>
                                </div>
                                @endif
                            </div>

                            <!-- SAĞ KOLON: Editör Çalışma Alanı -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold text-green-600">Editör Çalışma Alanı</h3>
                                    <button type="button" 
                                            id="ai-btn"
                                            onclick="generateAISummary()" 
                                            class="shadow-md hover:opacity-90 transition-all font-bold"
                                            style="background-color: #9333ea !important; color: #ffffff !important; padding: 6px 16px !important; border-radius: 8px !important; border: none !important; cursor: pointer !important; font-size: 11px !important; display: inline-flex !important; align-items: center !important; gap: 5px !important;">
                                        <span>🪄</span> AI İLE HAZIRLA (BAŞLIK + ÖZET)
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Türkçe Makale Başlığı (Title Translation)</label>
                                    <input type="text" id="turkish_title" name="turkish_title" value="{{ old('turkish_title', $article->turkish_title) }}" class="w-full rounded border-gray-300 text-sm font-bold bg-white text-gray-800 focus:border-green-500 focus:ring-green-500 p-2.5">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Türkçe Özet & Doktor Notları</label>
                                    <textarea id="abstract_tr" name="abstract_tr" rows="20" class="w-full rounded border-gray-300 text-sm leading-relaxed text-gray-700 focus:border-green-500 focus:ring-green-500 p-3 bg-white">{{ $article->abstract_tr }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 border rounded shadow-inner">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Verification Level (Katman)</label>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-xs mt-1 bg-white">
                                            <option value="1" {{ $article->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Verified Source (PubMed)</option>
                                            <option value="2" {{ $article->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Verified Institution</option>
                                            <option value="3" {{ $article->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Scientific News</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Curation Status (Durum)</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-xs mt-1 bg-white">
                                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $article->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $article->status == 'approved' ? 'selected' : '' }}>Onaylandı (Hazır)</option>
                                            <option value="rejected" {{ $article->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Yayınlandı (Canlı)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-6 flex justify-end gap-2 mt-4 border-t">
                                    <a href="{{ route('admin.research.index') }}" class="px-6 py-2.5 border rounded-lg text-xs font-bold text-gray-500 hover:bg-gray-100 uppercase tracking-wider transition font-black">İptal</a>
                                    <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-lg text-xs font-black shadow-lg hover:shadow-xl hover:bg-blue-700 uppercase tracking-widest transition">
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

    <!-- AI SCRIPT (DO NOT MOVE) -->
    <script>
    function generateAISummary() {
        const btn = document.getElementById('ai-btn');
        if (!btn) return;
        
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>🔄 HAZIRLANIYOR...</span>';
        
        const url = '{{ route('admin.research.ai-summary', $article) }}';
        
        fetch(url, {
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
                // Success: Refresh current view
                window.location.reload();
            } else {
                throw new Error(data.message || 'AI hatası oluştu');
            }
        })
        .catch(err => {
            alert('HATA: ' + err.message);
            btn.disabled = false;
            btn.innerHTML = originalContent;
        });
    }
    </script>
</x-app-layout>
