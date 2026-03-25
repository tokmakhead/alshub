<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Klinik Rehberler (NICE, AAN, EAN)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kurum / Başlık</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Yayın Tarihi</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Güven Katmanı</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($guidelines as $guideline)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] font-bold text-blue-600 uppercase">{{ $guideline->source_org }}</div>
                                        <div class="text-sm font-medium text-gray-900">{{ $guideline->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $guideline->publication_date ? $guideline->publication_date->format('d.m.Y') : 'Bilinmiyor' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-bold rounded bg-blue-50 text-blue-700 border border-blue-200">Tier {{ $guideline->verification_tier }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $guideline->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $guideline->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $guideline->status === 'in_review' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $guideline->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $guideline->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ strtoupper($guideline->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('admin.guidelines.edit', $guideline) }}" class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-2 py-1 rounded">İncele</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $guidelines->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
