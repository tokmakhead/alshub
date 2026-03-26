<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kaynak Düzenle') }}: {{ $source->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.sources.update', $source) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Kaynak Adı</label>
                            <input type="text" name="source_name" value="{{ old('source_name', $source->source_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Notlar / Açıklama</label>
                            <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $source->notes) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Erişim Modu</label>
                            <select name="source_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="api" {{ old('source_mode', $source->source_mode) === 'api' ? 'selected' : '' }}>API Entegrasyonu (Official)</option>
                                <option value="web_ingest" {{ old('source_mode', $source->source_mode) === 'web_ingest' ? 'selected' : '' }}>Web Ingestion (Scraping/Feed)</option>
                                <option value="manual" {{ old('source_mode', $source->source_mode) === 'manual' ? 'selected' : '' }}>Manuel Veri Girişi</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Durum</label>
                            <select name="is_enabled" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="1" {{ old('is_enabled', $source->is_enabled) ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !old('is_enabled', $source->is_enabled) ? 'selected' : '' }}>Pasif</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Güncelle</button>
                            <a href="{{ route('admin.sources.index') }}" class="text-gray-600">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
