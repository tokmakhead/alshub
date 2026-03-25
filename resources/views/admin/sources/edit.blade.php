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
                    <form action="{{ route('admin.sources.update', $source) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Kaynak Adı</label>
                            <input type="text" name="name" value="{{ $source->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Tip</label>
                            <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="publication" {{ $source->type === 'publication' ? 'selected' : '' }}>Research / Publication</option>
                                <option value="trial" {{ $source->type === 'trial' ? 'selected' : '' }}>Clinical Trial</option>
                                <option value="drug" {{ $source->type === 'drug' ? 'selected' : '' }}>Drug / Treatment</option>
                                <option value="article" {{ $source->type === 'article' ? 'selected' : '' }}>General ALS Article</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Base URL / Feed URL</label>
                            <textarea name="base_url" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ $source->base_url }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 text-sm">Durum</label>
                            <select name="is_active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="1" {{ $source->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$source->is_active ? 'selected' : '' }}>Pasif</option>
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
