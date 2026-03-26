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

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Ana İçerik Kolonu -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Orijinal Veri Kartı -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 italic">
                                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2 text-sm">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.082.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        PubMed Orijinal Verisi (EN)
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">PMID: {{ $article->pmid }}</label>
                                            <div class="text-sm font-bold text-gray-700 leading-tight">{{ $article->title }}</div>
                                        </div>
                                        <div class="text-xs text-gray-500 leading-relaxed max-h-40 overflow-y-auto pr-2">
                                            {{ $article->abstract_original }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Türkçe Düzenleme Kartı -->
                                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                            Yayına Hazırlık Bilgileri (TR)
                                        </h3>
                                        <button type="button" onclick="generateAISummary()" id="ai-btn" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:shadow-lg transition-all flex items-center gap-2">
                                            <span id="ai-text">🪄 AI İLE TÜRKÇELEŞTİR</span>
                                        </button>
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Makale Başlığı (Türkçe)</label>
                                            <input type="text" name="turkish_title" value="{{ $article->turkish_title }}" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Türkçe Özet & Analiz</label>
                                            <textarea id="abstract_tr" name="abstract_tr" rows="15" class="w-full rounded-xl border-gray-200 text-sm leading-relaxed focus:ring-primary focus:border-primary">{{ $article->abstract_tr }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Yan Panel: Durum ve Onay -->
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                                    <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Yayın Yönetimi
                                    </h3>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Güven Katmanı (Tier)</label>
                                            <select name="verification_tier" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-xs">
                                                <option value="1" {{ $article->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Resmi/Akademik</option>
                                                <option value="2" {{ $article->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Kurumsal/Vakıf</option>
                                                <option value="3" {{ $article->verification_tier == 3 ? 'selected' : '' }}>Tier 3 - Bilimsel Haber</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Yayın Durumu</label>
                                            <select name="status" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-xs uppercase tracking-tighter">
                                                <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                                <option value="in_review" {{ $article->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                                <option value="approved" {{ $article->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                                <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                            </select>
                                        </div>

                                        <div class="pt-6">
                                            <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-4 font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg transition-all">
                                                KAYDET VE GÜNCELLE
                                            </button>
                                            <a href="{{ route('admin.research.index') }}" class="block text-center mt-4 text-[10px] font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest">Listeye Geri Dön</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 italic">
                                    <h4 class="text-[10px] font-black text-blue-800 uppercase mb-2">Editör Notu</h4>
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        AI ile içerik üretildikten sonra metnin ALS Hub kalite standartlarına ("---" ayracı vb.) uygunluğunu kontrol ediniz.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                    function generateAISummary() {
                        const btn = document.getElementById('ai-btn');
                        if (!btn) return;
                        const oldText = btn.innerText;
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
                            btn.innerText = oldText;
                        });
                    }
                    </script>
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
