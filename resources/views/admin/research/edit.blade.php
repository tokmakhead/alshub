<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Makale İnceleme ve Onay') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow-sm border border-red-200 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 font-sans">
                    <form action="{{ route('admin.research.update', $article->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Hidden Required Fields -->
                        <input type="hidden" name="title" value="{{ $article->title }}">
                        <input type="hidden" name="journal" value="{{ $article->journal }}">
                        <input type="hidden" name="doi" value="{{ $article->doi }}">
                        <input type="hidden" name="publication_date" value="{{ $article->publication_date ? $article->publication_date->format('Y-m-d') : '' }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- SOL KOLON -->
                            <div class="space-y-4 border-r pr-8">
                                <h3 class="font-bold border-b pb-2 text-blue-600 uppercase text-xs tracking-wider">Orijinal Veriler</h3>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">PMID / Kaynak</label>
                                    <div class="p-2 bg-gray-50 border border-gray-100 rounded text-xs flex justify-between items-center">
                                        <span>{{ $article->pmid }}</span>
                                        <span class="bg-blue-100 text-blue-700 font-bold px-2 py-0.5 rounded-full" style="font-size: 9px;">
                                            PubMed (Tier {{ $article->verification_tier }})
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Orijinal Başlık</label>
                                    <div class="p-2 bg-gray-50 border border-gray-100 rounded text-xs font-semibold">{{ $article->title }}</div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Abstract (EN)</label>
                                    <div class="p-2 bg-gray-50 border border-gray-100 rounded text-xs h-80 overflow-y-auto leading-relaxed">{{ $article->abstract_original }}</div>
                                </div>
                            </div>

                            <!-- SAĞ KOLON -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold text-green-600 uppercase text-xs tracking-wider">Editör Alanı</h3>
                                    <button type="button" 
                                            id="ai-btn"
                                            onclick="generateAISummary()" 
                                            style="background-color: #9333ea; color: white; padding: 6px 14px; border-radius: 6px; border: none; font-weight: bold; font-size: 11px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                        🪄 AI İLE HAZIRLA
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Türkçe Başlık</label>
                                    <input type="text" name="turkish_title" value="{{ old('turkish_title', $article->turkish_title) }}" class="w-full rounded border-gray-200 text-sm font-bold bg-white mt-1 p-2">
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Türkçe Açıklama</label>
                                    <textarea id="abstract_tr" name="abstract_tr" rows="20" class="w-full rounded border-gray-200 text-xs leading-loose bg-white mt-1 p-3">{{ $article->abstract_tr }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 border rounded-lg">
                                    <div>
                                        <div class="flex items-center gap-1 mb-1">
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase">Katman (Tier)</label>
                                            <div class="group relative">
                                                <svg class="w-3 h-3 text-gray-300 cursor-help" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                <div class="hidden group-hover:block absolute z-50 w-64 p-3 bg-gray-900 text-white text-[10px] rounded-lg shadow-xl -left-20 bottom-5 leading-relaxed">
                                                    <strong>Tier 1:</strong> Resmi Kaynaklar (PubMed, FDA vb.)<br>
                                                    <strong>Tier 2:</strong> Kurumsal (Dernekler, Hastaneler vb.)<br>
                                                    <strong>Tier 3:</strong> Bilimsel Haberler (ScienceDaily vb.)
                                                </div>
                                            </div>
                                        </div>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-xs shadow-sm focus:ring-blue-500">
                                            <option value="1" {{ $article->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Resmi/Akademik Kaynak (Otomatik: PubMed)</option>
                                            <option value="2" {{ $article->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Kurumsal/Vakıf (Dernekler/Hastaneler)</option>
                                            <option value="3" {{ $article->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Bilimsel Haber/Basın (Medya)</option>
                                        </select>
                                        <p class="text-[9px] text-gray-400 mt-1 italic">Not: Kaynağa göre otomatik seçilmiştir; elzem durumlar dışında değiştirmeyin.</p>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Durum (Status)</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-xs mt-1">
                                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $article->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $article->status == 'approved' ? 'selected' : '' }}>Onaylandı (Hazır)</option>
                                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Yayınlandı (Canlı)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-6 flex justify-end gap-3 border-t">
                                    <a href="{{ route('admin.research.index') }}" class="px-5 py-2 border border-gray-200 rounded text-xs font-bold text-gray-500 hover:bg-gray-50 transition">İPTAL</a>
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
        
        fetch('{{ route('admin.research.ai-summary', $article->id) }}', {
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
