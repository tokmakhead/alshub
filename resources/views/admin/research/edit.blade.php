<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Makale İnceleme ve Onay') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-2xl">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.research.update', $article) }}" method="POST" id="research-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                            
                            <!-- SOL KOLON: Orijinal Veriler (Bilgi Paneli) -->
                            <div class="space-y-6 lg:border-r lg:pr-10">
                                <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                                    <h3 class="text-sm font-black text-blue-600 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        ORİJİNAL KAYNAK VERİSİ (PubMed)
                                    </h3>
                                    @if($article->pmid)
                                        <a href="https://pubmed.ncbi.nlm.nih.gov/{{ $article->pmid }}/" target="_blank" class="inline-flex items-center text-[10px] bg-blue-50 text-blue-600 px-3 py-1.5 rounded-full hover:bg-blue-100 transition-all font-bold uppercase tracking-widest border border-blue-100">
                                            PubMed'de Gör ↗
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">PMID</label>
                                        <div class="text-xs font-mono text-gray-800">{{ $article->pmid }}</div>
                                    </div>
                                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">DOI</label>
                                        <div class="text-xs font-mono text-gray-800 truncate" title="{{ $article->doi }}">{{ $article->doi ?: 'Belirtilmemiş' }}</div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Makale Başlığı (Orijinal)</label>
                                    <div class="p-5 bg-blue-50/30 border border-blue-100 rounded-2xl text-sm text-gray-800 font-semibold leading-relaxed italic shadow-inner">
                                        "{{ $article->title }}"
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Yazarlar</label>
                                    <div class="p-4 bg-gray-50/50 border border-gray-100 rounded-xl text-xs text-gray-600 leading-relaxed font-medium">
                                        {{ is_array($article->authors_json) ? implode(', ', $article->authors_json) : ($article->authors_json ?: 'Bilinmiyor') }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">İngilizce Özet (Abstract)</label>
                                    <div class="p-5 bg-gray-50/50 border border-gray-100 rounded-2xl text-xs text-gray-600 h-80 overflow-y-auto leading-loose antialiased scrollbar-thin scrollbar-thumb-gray-200">
                                        {{ $article->abstract_original }}
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Dergi</label>
                                        <div class="text-[11px] font-bold text-gray-700 truncate capitalize">{{ $article->journal }}</div>
                                    </div>
                                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Yayın Tarihi</label>
                                        <div class="text-[11px] font-bold text-gray-700 uppercase">{{ $article->publication_date ? $article->publication_date->format('d M Y') : 'Bilinmiyor' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- SAĞ KOLON: Editör Çalışma Alanı -->
                            <div class="space-y-6">
                                <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                                    <h3 class="text-sm font-black text-emerald-600 flex items-center gap-2 uppercase tracking-tighter">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Editör Çalışma Alanı (Türkçe Çeviri)
                                    </h3>
                                    <button type="button" 
                                            id="ai-button"
                                            onclick="generateAISummary()" 
                                            class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-700 text-white px-5 py-2 rounded-full text-[11px] font-black shadow-lg shadow-purple-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 ring-4 ring-purple-50">
                                        <span>🪄 AI İLE HAZIRLA</span>
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">MAKALE TÜRKÇE BAŞLIĞI</label>
                                    <input type="text" 
                                           id="turkish_title" 
                                           name="turkish_title" 
                                           value="{{ old('turkish_title', $article->turkish_title) }}" 
                                           class="w-full rounded-2xl border-gray-100 focus:border-emerald-500 focus:ring-emerald-500 text-sm font-bold text-gray-800 shadow-sm p-4 bg-gray-50/30" 
                                           placeholder="AI tarafından çevrilen başlık burada görünecek...">
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">TÜRKÇE ÖZET VE DOKTOR NOTLARI</label>
                                    <textarea id="abstract_tr" 
                                              name="abstract_tr" 
                                              rows="22" 
                                              class="w-full rounded-2xl border-gray-100 focus:border-emerald-500 focus:ring-emerald-500 text-sm leading-relaxed text-gray-700 shadow-sm p-5 bg-gray-50/30"
                                              placeholder="AI tarafından hazırlanan bilimsel özet, hasta özeti ve doktor notları burada yer alır...">{{ $article->abstract_tr }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-emerald-50/30 p-6 rounded-3xl border border-emerald-100/50 shadow-inner">
                                    <div>
                                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Güven Katmanı (Trust)</label>
                                        <select name="verification_tier" class="w-full rounded-xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 text-xs font-bold text-emerald-900 bg-white">
                                            <option value="1" {{ $article->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Verified Source (PubMed)</option>
                                            <option value="2" {{ $article->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - verified Institution</option>
                                            <option value="3" {{ $article->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Scientific News</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Kürasyon Durumu</label>
                                        <select name="status" class="w-full rounded-xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 text-xs font-bold text-emerald-900 bg-white">
                                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $article->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $article->status == 'approved' ? 'selected' : '' }}>Onaylandı (Hazır)</option>
                                            <option value="rejected" {{ $article->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Yayınlandı (Canlı)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-8 flex justify-end gap-4">
                                    <a href="{{ route('admin.research.index') }}" class="px-8 py-3 border border-gray-100 text-gray-400 rounded-2xl text-[11px] font-black hover:bg-gray-50 transition uppercase tracking-widest">İptal</a>
                                    <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-2xl text-[11px] font-black shadow-2xl hover:shadow-gray-300 hover:bg-black transition-all uppercase tracking-widest">
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

    <!-- AI SCRIPT -->
    <script>
    function generateAISummary() {
        const btn = document.getElementById('ai-button');
        if (!btn) return;
        
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>🔄 HAZIRLANIYOR...</span>';
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        
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
                // Success: Refresh to show new title and abstract
                window.location.reload();
            } else {
                throw new Error(data.message || 'AI hatası oluştu');
            }
        })
        .catch(err => {
            alert('HATA: ' + err.message);
            btn.disabled = false;
            btn.innerHTML = originalContent;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
        });
    }
    </script>
</x-app-layout>
