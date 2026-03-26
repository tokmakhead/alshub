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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NCT ID / Başlık</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faz / Statü</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Güven Katmanı</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Onay Durumu</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($trials as $trial)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-gray-400">NCT ID: {{ $trial->nct_id }}</div>
                                        <div class="text-sm font-medium text-gray-900">{{ $trial->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="font-bold">{{ $trial->phase ?? 'N/A' }}</div>
                                        <div class="text-xs">{{ $trial->recruitment_status }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-bold rounded bg-blue-50 text-blue-700 border border-blue-200">Tier {{ $trial->verification_tier }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $trial->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $trial->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $trial->status === 'in_review' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $trial->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $trial->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ strtoupper(str_replace('_', ' ', $trial->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.trials.edit', $trial) }}" class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-2 py-1 rounded">Düzenle</a>
                                            <form action="{{ route('admin.trials.destroy', $trial) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 border border-red-600 px-2 py-1 rounded">Sil</button>
                                            </form>
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
</x-app-layout>
