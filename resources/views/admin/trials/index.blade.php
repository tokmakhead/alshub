<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Klinik Çalışmalar (ClinicalTrials.gov)') }}
            </h2>
            <div class="flex items-center gap-4">
                <form action="{{ route('admin.trials.index') }}" method="GET" class="flex gap-2">
                    <select name="status" class="rounded-lg border-gray-200 text-sm focus:ring-blue-500">
                        <option value="">Tüm Durumlar</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Taslak</option>
                        <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Onaylı</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                    </select>
                    <button type="submit" class="bg-gray-800 text-white px-4 py-1 rounded-lg text-sm hover:bg-black transition">Filtrele</button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-0">
                    <table class="min-w-full divide-y divide-gray-100 italic-header">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Çalışma / Sponsor</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Faz & Tedavi</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">AI Durumu</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Durum & Aksiyon</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @foreach($trials as $trial)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] bg-blue-50 text-blue-600 font-black px-2 py-0.5 rounded border border-blue-100">
                                                {{ $trial->nct_id }}
                                            </span>
                                            <a href="https://clinicaltrials.gov/study/{{ $trial->nct_id }}" target="_blank" class="text-gray-300 hover:text-blue-500 transition">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                        <div class="text-sm font-bold text-gray-900 leading-snug max-w-md">{{ $trial->title }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium mt-1 uppercase tracking-tighter">
                                            <span class="text-gray-500 font-bold">Sponsor:</span> {{ $trial->sponsor ?? 'Belirtilmemiş' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded uppercase">
                                                    {{ $trial->phase ?: 'Faz Belirtilmemiş' }}
                                                </span>
                                                <span class="text-[10px] font-bold text-gray-500 line-clamp-1">
                                                    {{ $trial->recruitment_status }}
                                                </span>
                                            </div>
                                            <div class="text-[11px] text-gray-600 font-medium line-clamp-1 italic">
                                                {{ $trial->intervention ?: 'Detay yok' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($trial->summary && str_contains($trial->summary, '---'))
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                                TÜRKÇE OK
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-gray-50 text-gray-400 border border-gray-100">
                                                EKSİK
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex flex-col items-end gap-3">
                                            <div class="flex items-center gap-2">
                                                <span id="status-badge-{{ $trial->id }}" class="px-2 py-1 inline-flex text-[9px] leading-4 font-black rounded-md border 
                                                    {{ $trial->status === 'published' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                                                    {{ strtoupper(str_replace('_', ' ', $trial->status)) }}
                                                </span>
                                                <button onclick="toggleTrialStatus({{ $trial->id }})" class="p-1.5 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition shadow-sm">
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                                </button>
                                            </div>
                                            
                                            <div class="flex gap-2">
                                                <button onclick="reSyncTrial({{ $trial->id }})" title="API'den Güncelle" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </button>
                                                <a href="{{ route('admin.trials.edit', $trial) }}" class="p-1.5 text-indigo-600 hover:bg-indigo-50 border border-indigo-100 rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('admin.trials.destroy', $trial) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($trials->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $trials->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleTrialStatus(id) {
            fetch(`{{ url('admin/trials') }}/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const badge = document.getElementById(`status-badge-${id}`);
                    badge.innerText = data.new_status.toUpperCase();
                    if(data.new_status === 'published') {
                        badge.className = 'px-2 py-1 inline-flex text-[9px] leading-4 font-black rounded-md border bg-green-50 text-green-700 border-green-200';
                    } else {
                        badge.className = 'px-2 py-1 inline-flex text-[9px] leading-4 font-black rounded-md border bg-gray-50 text-gray-500 border-gray-200';
                    }
                }
            });
        }

        function reSyncTrial(id) {
            Swal.fire({
                title: 'Güncelleniyor...',
                text: 'ClinicalTrials.gov verileri çekiliyor.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(`{{ url('admin/trials') }}/${id}/fetch`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire('Başarılı', data.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Hata', data.message, 'error');
                }
            });
        }
    </script>

    <style>
        .italic-header th { font-style: italic; letter-spacing: 0.1em; }
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</x-app-layout>
