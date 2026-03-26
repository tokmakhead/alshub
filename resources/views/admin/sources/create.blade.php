<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Kaynak Ekle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.sources.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Kaynak Adı</label>
                            <input type="text" name="source_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Notlar / Açıklama</label>
                            <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Yöntem / Erişim Modu</label>
                            <select name="source_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="api">API Entegrasyonu (Official)</option>
                                <option value="web_ingest">Web Ingest (Scraping/Feed)</option>
                                <option value="manual">Manual Entry</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kaydet</button>
                            <a href="{{ route('admin.sources.index') }}" class="text-gray-600">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
