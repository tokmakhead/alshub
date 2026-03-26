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
                    <button type="submit" class="bg-gray-200 px-4 py-1.5 rounded-xl text-sm font-bold hover:bg-gray-300 transition shadow-sm border border-gray-300">Filtrele</button>
                </form>
                <a href="{{ route('admin.drugs.create') }}" class="bg-primary text-white px-4 py-1.5 rounded-xl text-sm font-bold hover:bg-blue-800 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Yeni İlaç Ekle
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-0 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">İlaç Kimliği & Endikasyon</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">FDA / EMA Statü</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">Güven & Doğrulama</th>
                                    <th class="px-6 py-4 bg-gray-50 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">Yayın Durumu</th>
                                    <th class="px-6 py-4 bg-gray-50 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest text-nowrap">Aksiyon</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($drugs as $drug)
                                    <tr class="hover:bg-gray-50/80 transition-all duration-200 group odd:bg-gray-50/30">
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-black text-gray-900 leading-tight group-hover:text-primary transition">{{ $drug->generic_name }}</span>
                                                    @if($drug->brand_name)
                                                        <span class="text-xs text-gray-400 font-medium italic">({{ $drug->brand_name }})</span>
                                                    @endif
                                                </div>
                                                @if($drug->indication)
                                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-1 max-w-xs">{{ $drug->indication }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex justify-center items-center gap-4">
                                                <!-- FDA Box -->
                                                <div class="flex flex-col items-center group/link">
                                                    <span class="text-[9px] font-black text-blue-500 mb-1 tracking-tighter uppercase">FDA</span>
                                                    @if($drug->fda_link)
                                                        <a href="{{ $drug->fda_link }}" target="_blank" class="w-8 h-8 rounded-xl border {{ $drug->is_approved_fda ? 'bg-blue-50 border-blue-200 text-blue-600' : 'bg-gray-50 border-gray-200 text-gray-300' }} flex items-center justify-center hover:scale-110 hover:shadow-lg transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        </a>
                                                    @else
                                                        <div class="w-8 h-8 rounded-xl border border-dashed border-gray-200 flex items-center justify-center text-gray-200">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <!-- EMA Box -->
                                                <div class="flex flex-col items-center group/link">
                                                    <span class="text-[9px] font-black text-indigo-500 mb-1 tracking-tighter uppercase">EMA</span>
                                                    @if($drug->ema_link)
                                                        <a href="{{ $drug->ema_link }}" target="_blank" class="w-8 h-8 rounded-xl border {{ $drug->is_approved_ema ? 'bg-indigo-50 border-indigo-200 text-indigo-600' : 'bg-gray-50 border-gray-200 text-gray-300' }} flex items-center justify-center hover:scale-110 hover:shadow-lg transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        </a>
                                                    @else
                                                        <div class="w-8 h-8 rounded-xl border border-dashed border-gray-200 flex items-center justify-center text-gray-200">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <div class="flex flex-col items-center">
                                                <span class="px-3 py-0.5 text-[10px] font-black rounded-lg border border-blue-200 bg-blue-50 text-blue-700 uppercase tracking-widest">
                                                    Tier {{ $drug->verification_tier }}
                                                </span>
                                                <span class="text-[9px] text-gray-400 mt-2 font-medium">Son Doğrulama:</span>
                                                <span class="text-[10px] text-gray-600 font-bold uppercase">{{ $drug->last_verified_at ? $drug->last_verified_at->translatedFormat('d F Y') : 'Bekliyor' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <button onclick="togglePublic('{{ $drug->id }}')" id="status-badge-{{ $drug->id }}" class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all shadow-sm
                                                {{ $drug->status === 'published' ? 'bg-green-500 text-white border-green-500 shadow-green-100 hover:bg-green-600' : 'bg-white text-gray-400 border-gray-200 hover:border-gray-400 hover:text-gray-600' }}">
                                                {{ $drug->status === 'published' ? 'CANLI' : 'TASLAK' }}
                                            </button>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('admin.drugs.edit', $drug) }}" class="p-2.5 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all border border-indigo-100 hover:border-indigo-300 shadow-sm" title="Düzenle">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('admin.drugs.destroy', $drug) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 text-red-500 hover:bg-red-50 rounded-xl transition-all border border-red-100 hover:border-red-300 shadow-sm" title="Sil">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                <span class="text-gray-400 font-bold italic">Kayıtlı ilaç bulunmuyor.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-8 border-t border-gray-100 bg-gray-50/50">
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
                                if (data.status === 'published' || data.new_status === 'published') {
                                    btn.className = 'px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all shadow-sm bg-green-500 text-white border-green-500 shadow-green-100 hover:bg-green-600';
                                    btn.innerText = 'CANLI';
                                } else {
                                    btn.className = 'px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all shadow-sm bg-white text-gray-400 border-gray-200 hover:border-gray-400 hover:text-gray-600';
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
