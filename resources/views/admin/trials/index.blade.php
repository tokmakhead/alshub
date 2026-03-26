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
                        <option value="draft">Taslak</option>
                        <option value="in_review">İnceleme Bekliyor</option>
                        <option value="approved">Onaylandı</option>
                        <option value="published">Yayınlandı</option>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">NCT ID / Çalışma Başlığı</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">Faz / Statü (CT.GOV)</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">Güven Katmanı</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">Yayın Durumu</th>
                                    <th class="px-6 py-4 bg-gray-50 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">Aksiyon</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($trials as $trial)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-black text-gray-400 mb-1 uppercase tracking-tighter">NCT ID: {{ $trial->nct_id }}</span>
                                                <span class="text-sm font-black text-gray-900 leading-tight group-hover:text-primary transition line-clamp-2">{{ $trial->title }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-nowrap">
                                            <div class="flex flex-col items-center">
                                                <span class="text-xs font-bold text-gray-700 leading-none">{{ $trial->phase ?? 'N/A' }}</span>
                                                <span class="text-[10px] text-gray-400 mt-1 font-medium italic">{{ $trial->recruitment_status }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 text-[10px] font-black rounded-lg border border-blue-200 bg-blue-50 text-blue-700 uppercase tracking-widest">
                                                Tier {{ $trial->verification_tier }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button onclick="togglePublic('{{ $trial->id }}')" id="status-badge-{{ $trial->id }}" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border transition-all
                                                {{ $trial->status === 'published' ? 'bg-green-500 text-white border-green-500 shadow-sm shadow-green-200' : 'bg-gray-100 text-gray-500 border-gray-200 hover:bg-gray-200' }}">
                                                {{ $trial->status === 'published' ? 'CANLI' : 'TASLAK' }}
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('admin.trials.edit', $trial) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors border border-indigo-100" title="Düzenle">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('admin.trials.destroy', $trial) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors border border-red-100" title="Sil">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-bold italic">Klinik çalışma kaydı bulunmuyor.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8">
                        {{ $trials->links() }}
                    </div>

                    <script>
                    function togglePublic(id) {
                        const btn = document.getElementById('status-badge-' + id);
                        btn.disabled = true;
                        btn.style.opacity = '0.5';

                        fetch(`/admin/trials/${id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.status === 'published' || data.new_status === 'published') {
                                    btn.className = 'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border transition-all bg-green-500 text-white border-green-500 shadow-sm shadow-green-200';
                                    btn.innerText = 'CANLI';
                                } else {
                                    btn.className = 'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border transition-all bg-gray-100 text-gray-500 border-gray-200 hover:bg-gray-200';
                                    btn.innerText = 'TASLAK';
                                }
                            }
                        })
                        .catch(error => alert('Hata: ' + error))
                        .finally(() => {
                            btn.disabled = false;
                            btn.style.opacity = '1';
                        });
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
