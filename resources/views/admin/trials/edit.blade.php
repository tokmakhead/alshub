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

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Ana İçerik Kolonu -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Orijinal Veri Kartı -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 italic">
                                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2 text-sm">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 01-.586 1.414l-2.828 2.828a2 2 0 01-2.828 0L7.172 11.586A2 2 0 016.586 10.172V5L5 4h3"></path></svg>
                                        ClinicalTrials.gov Orijinal Verisi (EN)
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">NCT ID: {{ $trial->nct_id }}</label>
                                            <div class="text-sm font-bold text-gray-700 leading-tight">{{ $trial->title }}</div>
                                        </div>
                                        <div class="text-xs text-gray-500 leading-relaxed max-h-40 overflow-y-auto pr-2">
                                            {{ $trial->summary }}
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-200/50">
                                            <div>
                                                <label class="block text-[9px] font-black text-gray-400 uppercase">Faz Bilgisi</label>
                                                <span class="text-xs font-bold text-gray-600">{{ $trial->phase ?: 'Belirtilmemiş' }}</span>
                                            </div>
                                            <div>
                                                <label class="block text-[9px] font-black text-gray-400 uppercase">Sponsor</label>
                                                <span class="text-xs font-bold text-gray-600 line-clamp-1">{{ $trial->sponsor }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Türkçe Düzenleme Kartı -->
                                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                            Klinik Çalışma Detayları (TR)
                                        </h3>
                                        <button type="button" onclick="generateAISummary()" id="ai-btn" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:shadow-lg transition-all flex items-center gap-2">
                                            <span id="ai-text">🪄 AI İLE TÜRKÇELEŞTİR</span>
                                        </button>
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Çalışma Başlığı (Türkçe)</label>
                                            <input type="text" name="title_tr" value="{{ $trial->title_tr }}" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Özet ve Detaylı Analiz</label>
                                            <textarea id="summary_tr" name="summary_tr" rows="15" class="w-full rounded-xl border-gray-200 text-sm leading-relaxed focus:ring-primary focus:border-primary">{{ $trial->summary_tr }}</textarea>
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
                                            <select name="verification_tier" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-xs uppercase">
                                                <option value="1" {{ $trial->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Resmi Klinik Kaynak</option>
                                                <option value="2" {{ $trial->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Yerel/Hanehalkı Kaynak</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Yayın Durumu</label>
                                            <select name="status" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-xs uppercase tracking-tighter">
                                                <option value="draft" {{ $trial->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                                <option value="in_review" {{ $trial->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                                <option value="approved" {{ $trial->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                                <option value="published" {{ $trial->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                            </select>
                                        </div>

                                        <div class="pt-6">
                                            <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-4 font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg transition-all">
                                                GÜNCELLE VE KAYDET
                                            </button>
                                            <a href="{{ route('admin.trials.index') }}" class="block text-center mt-4 text-[10px] font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest">Listeye Geri Dön</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 italic">
                                    <h4 class="text-[10px] font-black text-blue-800 uppercase mb-2">Önemli Hatırlatma</h4>
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        Klinik çalışmaların status bilgisi (Recruiting, Terminated vb.) anasayfadaki banner rengini belirler. AI özetinin temizlendiğinden emin olun.
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
