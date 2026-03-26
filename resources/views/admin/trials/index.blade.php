<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Klinik Çalışmalar (ClinicalTrials.gov)') }}
            </h2>
            <div class="flex items-center gap-4">
                <form action="{{ route('admin.trials.index') }}" method="GET" class="flex gap-2">
                    <select name="status" class="rounded border-gray-300 text-sm">
                        <option value="">Tüm Durumlar</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Taslak</option>
                        <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Onaylı</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                    </select>
                    <button type="submit" class="bg-gray-200 px-3 py-1 rounded text-sm hover:bg-gray-300">Filtrele</button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Çalışma / Sponsor</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faz & Tedavi</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">AI</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Durum & İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($trials as $trial)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] font-bold text-gray-400">NCT: {{ $trial->nct_id }}</span>
                                            <a href="https://clinicaltrials.gov/study/{{ $trial->nct_id }}" target="_blank" class="text-gray-300 hover:text-blue-500">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">{{ $trial->title }}</div>
                                        <div class="text-[10px] text-gray-400 mt-1">
                                            Sponsor: {{ $trial->sponsor ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="font-bold text-indigo-600 text-xs">{{ $trial->phase ?: 'N/A' }}</div>
                                        <div class="text-[10px] text-gray-400 italic mb-1">{{ $trial->recruitment_status }}</div>
                                        <div class="text-[10px] font-medium text-gray-600">{{ $trial->intervention }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($trial->summary && str_contains($trial->summary, '---'))
                                            <span class="px-2 py-0.5 text-[9px] font-bold rounded bg-green-50 text-green-700 border border-green-200 uppercase">TR OK</span>
                                        @else
                                            <span class="px-2 py-0.5 text-[9px] font-bold rounded bg-gray-50 text-gray-400 border border-gray-100 italic">Eksik</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex flex-col items-end gap-2">
                                            <div class="flex items-center gap-1">
                                                <span id="status-badge-{{ $trial->id }}" class="px-2 inline-flex text-[10px] leading-5 font-semibold rounded-full 
                                                    {{ $trial->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $trial->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $trial->status === 'in_review' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $trial->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                                    {{ $trial->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                ">
                                                    {{ strtoupper(str_replace('_', ' ', $trial->status)) }}
                                                </span>
                                                <button onclick="toggleTrialStatus({{ $trial->id }})" class="p-1 text-gray-400 hover:text-blue-600 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                                </button>
                                            </div>
                                            
                                            <div class="flex gap-2">
                                                <button onclick="reSyncTrial({{ $trial->id }})" title="Güncelle" class="text-blue-500 hover:text-blue-700 p-1 border border-blue-200 rounded">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </button>
                                                <a href="{{ route('admin.trials.edit', $trial) }}" class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-2 py-1 rounded text-xs">Düzenle</a>
                                                <form action="{{ route('admin.trials.destroy', $trial) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 border border-red-600 px-2 py-1 rounded text-xs">Sil</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $trials->links() }}
                    </div>
                </div>
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
                    badge.innerText = data.new_status.toUpperCase().replace('_', ' ');
                    
                    // Reset classes
                    badge.className = 'px-2 inline-flex text-[10px] leading-5 font-semibold rounded-full ';
                    if(data.new_status === 'published') badge.classList.add('bg-green-100', 'text-green-800');
                    else if(data.new_status === 'draft') badge.classList.add('bg-gray-100', 'text-gray-800');
                    else badge.classList.add('bg-blue-100', 'text-blue-800');
                }
            });
        }

        function reSyncTrial(id) {
            Swal.fire({
                title: 'Güncelleniyor...',
                text: 'ClinicalTrials.gov verileri çekiliyor.',
                allowOutsideClick: false,
                showConfirmButton: false,
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
                    Swal.fire({icon:'success', title:'Başarılı', text:data.message, timer:1500}).then(() => location.reload());
                } else {
                    Swal.fire('Hata', data.message, 'error');
                }
            });
        }
    </script>
</x-app-layout>
