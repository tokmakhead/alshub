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
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Tip</label>
                            <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="publication">Research / Publication</option>
                                <option value="trial">Clinical Trial</option>
                                <option value="drug">Drug / Treatment</option>
                                <option value="article">General ALS Article</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Base URL / Feed URL</label>
                            <input type="url" name="base_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Yöntem</label>
                            <select name="fetch_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="rss">RSS Feed</option>
                                <option value="api">API Integration</option>
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
