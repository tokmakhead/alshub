<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Uzmanlık Merkezleri (Hastaneler & Enstitüler)') }}
            </h2>
            <a href="{{ route('admin.expert-centers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-bold hover:bg-blue-700">Yeni Merkez Ekle</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Merkez Adı / Lokasyon</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uzman Sayısı</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doğrulama</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($centers as $center)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $center->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $center->location_city }}, {{ $center->location_country }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $center->doctors_count }} Uzman
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($center->is_verified)
                                            <span class="px-2 py-1 text-[10px] font-bold bg-green-100 text-green-800 rounded-full">✓ DOĞRULANMIŞ</span>
                                        @else
                                            <span class="px-2 py-1 text-[10px] font-bold bg-gray-100 text-gray-400 rounded-full">BEKLEMEDE</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('admin.expert-centers.edit', $center) }}" class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-2 py-1 rounded">Düzenle</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $centers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
