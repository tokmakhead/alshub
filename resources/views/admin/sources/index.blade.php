<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kaynak Yönetimi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('admin.sources.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Yeni Kaynak Ekle</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ad</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sources as $source)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $source->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $source->type }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $source->is_active ? 'Aktif' : 'Pasif' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium flex gap-2">
                                        <a href="{{ route('admin.sources.edit', $source) }}" class="text-indigo-600 hover:text-indigo-900">Düzenle</a>
                                        <form action="{{ route('admin.sources.fetch', $source) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Şimdi Çek</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
