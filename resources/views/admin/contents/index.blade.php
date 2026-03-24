<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('İçerik Yönetimi') }}
            </h2>
            <form action="{{ route('admin.contents.index') }}" method="GET" class="flex gap-2">
                <select name="status" class="rounded border-gray-300 text-sm">
                    <option value="">Tüm Durumlar</option>
                    <option value="draft">Taslak</option>
                    <option value="review">Onay Bekleyen</option>
                    <option value="published">Yayınlandı</option>
                </select>
                <button type="submit" class="bg-gray-200 px-3 py-1 rounded text-sm">Filtrele</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Başlık (Orijinal / TR)</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kaynak</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($contents as $content)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $content->original_title }}</div>
                                        <div class="text-sm text-blue-600">{{ $content->translated_title ?? 'Çeviri Yok' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $content->source->name ?? $content->source_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $content->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $content->status === 'review' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $content->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                        ">
                                            {{ strtoupper($content->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $content->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('admin.contents.edit', $content) }}" class="text-indigo-600 hover:text-indigo-900">Düzenle</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $contents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
