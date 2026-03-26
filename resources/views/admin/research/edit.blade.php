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
                            <!-- Orijinal Veriler (Read Only) -->
                            <div class="space-y-4 border-r pr-6">
                                <h3 class="font-bold border-b pb-2 text-blue-600">Orijinal Kaynak Verisi (PubMed)</h3>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">PMID</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm">{{ $article->pmid }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Başlık</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm">{{ $article->title }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Abstract (EN)</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs h-64 overflow-y-auto">{{ $article->abstract_original }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Dergi / Yayın Tarihi</label>
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
                                    <div class="p-2 bg-gray-50 border rounded text-xs">{{ $article->doi }}</div>
                                </div>
                                @endif
                            </div>

                            <!-- Düzenlenebilir / Onay Verileri -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold text-green-600">Editör Çalışma Alanı</h3>
                                    <button type="button" 
                                            id="ai-btn"
                                            onclick="generateAISummary()" 
                                            class="bg-purple-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-purple-700 shadow-sm"
                                            style="display: block !important;">
                                        🪄 AI ile Hazırla
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Türkçe Başlık</label>
                                    <input type="text" name="turkish_title" id="turkish_title" value="{{ old('turkish_title', $article->turkish_title) }}" class="w-full rounded border-gray-300 text-sm font-bold">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Türkçe Özet & Notlar</label>
                                    <textarea id="abstract_tr" name="abstract_tr" rows="18" class="w-full rounded border-gray-300 text-sm leading-relaxed">{{ $article->abstract_tr }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Tier</label>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-xs">
                                            <option value="1" {{ $article->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Verified</option>
                                            <option value="2" {{ $article->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Institution</option>
                                            <option value="3" {{ $article->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - News</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Durum</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-xs">
                                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="approved" {{ $article->status == 'approved' ? 'selected' : '' }}>Onaylı</option>
                                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t mt-4">
                                    <a href="{{ route('admin.research.index') }}" class="px-4 py-2 border rounded text-sm hover:bg-gray-50">İptal</a>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold shadow-md hover:bg-blue-700">Değişiklikleri Kaydet</button>
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

            btn.disabled = true;
            btn.innerText = 'Hazırlanıyor...';
            
            fetch('{{ route('admin.research.ai-summary', $article) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                } else {
                    alert('Hata: ' + data.message);
                    btn.disabled = false;
                    btn.innerText = '🪄 AI ile Hazırla';
                }
            })
            .catch(err => {
                alert('Sunucu Hatası: ' + err);
                btn.disabled = false;
                btn.innerText = '🪄 AI ile Hazırla';
            });
        }
    </script>
</x-app-layout>
