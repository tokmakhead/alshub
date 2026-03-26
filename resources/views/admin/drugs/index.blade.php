<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('İlaçlar (FDA / EMA Tracker)') }}
            </h2>
            <div class="flex items-center gap-4">
                <form action="{{ route('admin.drugs.index') }}" method="GET" class="flex gap-2">
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
                                    <th class="px-6 py-4 bg-gray-50 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">İlaç Kimliği (Generic / Brand)</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest">Global Takip</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest">Onay Kaynağı</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest">Yayın Durumu</th>
                                    <th class="px-6 py-4 bg-gray-50 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Aksiyon</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($drugs as $drug)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-black text-gray-900 leading-tight">{{ $drug->generic_name }}</span>
                                                <span class="text-xs text-gray-400 font-medium italic">{{ $drug->brand_name ?: 'Ticari isim belirtilmemiş' }}</span>
                                                @if($drug->indication)
                                                    <span class="text-[10px] text-primary font-bold mt-1 bg-blue-50 px-2 py-0.5 rounded-md inline-block w-fit">{{ Str::limit($drug->indication, 50) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center items-center gap-3">
                                                <div class="flex flex-col items-center">
                                                    <span class="text-[9px] font-black text-gray-400 mb-1 uppercase">FDA</span>
                                                    @if($drug->fda_link)
                                                        <a href="{{ $drug->fda_link }}" target="_blank" class="w-8 h-8 rounded-lg border {{ $drug->is_approved_fda ? 'bg-blue-50 border-blue-200 text-blue-600' : 'bg-gray-50 border-gray-200 text-gray-300' }} flex items-center justify-center hover:shadow-md transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        </a>
                                                    @else
                                                        <span class="w-8 h-8 rounded-lg border border-dashed border-gray-200 flex items-center justify-center text-gray-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex flex-col items-center">
                                                    <span class="text-[9px] font-black text-gray-400 mb-1 uppercase">EMA</span>
                                                    @if($drug->ema_link)
                                                        <a href="{{ $drug->ema_link }}" target="_blank" class="w-8 h-8 rounded-lg border {{ $drug->is_approved_ema ? 'bg-indigo-50 border-indigo-200 text-indigo-600' : 'bg-gray-50 border-gray-200 text-gray-300' }} flex items-center justify-center hover:shadow-md transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        </a>
                                                    @else
                                                        <span class="w-8 h-8 rounded-lg border border-dashed border-gray-200 flex items-center justify-center text-gray-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 text-[10px] font-black rounded-lg border border-blue-200 bg-blue-50 text-blue-700 uppercase tracking-widest">
                                                Tier {{ $drug->verification_tier }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button onclick="togglePublic('{{ $drug->id }}')" id="status-badge-{{ $drug->id }}" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border transition-all
                                                {{ $drug->status === 'published' ? 'bg-green-500 text-white border-green-500 shadow-sm shadow-green-200' : 'bg-gray-100 text-gray-500 border-gray-200 hover:bg-gray-200' }}">
                                                {{ $drug->status === 'published' ? 'CANLI' : 'TASLAK' }}
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('admin.drugs.edit', $drug) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors border border-indigo-100" title="Düzenle">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('admin.drugs.destroy', $drug) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')" class="inline">
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
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-bold italic">Kayıtlı ilaç bulunmuyor.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8">
                        {{ $drugs->links() }}
                    </div>

                    <script>
                    function togglePublic(id) {
                        const btn = document.getElementById('status-badge-' + id);
                        btn.disabled = true;
                        btn.style.opacity = '0.5';

                        fetch(`/admin/drugs/${id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.status === 'published') {
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
