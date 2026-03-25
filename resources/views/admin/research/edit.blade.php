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
                                    <div class="p-2 bg-gray-50 border rounded text-xs h-40 overflow-y-auto">{{ $article->abstract_original }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Dergi</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm">{{ $article->journal }}</div>
                                </div>
                            </div>

                            <!-- Düzenlenebilir / Onay Verileri -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold text-green-600">Editör Çalışma Alanı (Türkçe Çeviri/Özet)</h3>
                                    <button type="button" onclick="generateAISummary()" class="bg-purple-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-purple-700">🪄 AI ile Hazırla</button>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Türkçe Abstract / Özet</label>
                                    <textarea id="abstract_tr" name="abstract_tr" rows="15" class="w-full rounded border-gray-300 text-sm">{{ $article->abstract_tr }}</textarea>
                                </div>

                                <script>
                                    function generateAISummary() {
                                        const btn = event.target;
                                        btn.disabled = true;
                                        btn.innerText = 'Hazırlanıyor...';
                                        
                                        fetch('{{ route('admin.research.ai-summary', $article) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if(data.success) {
                                                location.reload();
                                            } else {
                                                alert('Hata: ' + data.message);
                                                btn.disabled = false;
                                                btn.innerText = '🪄 AI ile Hazırla';
                                            }
                                        });
                                    }
                                </script>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Doğrulama Katmanı (Tier)</label>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-sm">
                                            <option value="1" {{ $article->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Verified Source</option>
                                            <option value="2" {{ $article->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Verified Institution</option>
                                            <option value="3" {{ $article->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Scientific News</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Yayın Durumu</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-sm">
                                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $article->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $article->status == 'approved' ? 'selected' : '' }}>Onaylandı (Hazır)</option>
                                            <option value="rejected" {{ $article->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Yayınlandı (Canlı)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2">
                                    <a href="{{ route('admin.research.index') }}" class="px-4 py-2 border rounded text-sm hover:bg-gray-50">İptal</a>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-700">Değişiklikleri Kaydet ve Güncelle</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
