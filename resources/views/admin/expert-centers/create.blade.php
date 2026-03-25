<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($center) ? 'Merkez Düzenle' : 'Yeni Uzmanlık Merkezi' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($center) ? route('admin.expert-centers.update', $center) : route('admin.expert-centers.store') }}" method="POST">
                        @csrf
                        @if(isset($center)) @method('PUT') @endif

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Merkez Adı</label>
                                <input type="text" name="name" value="{{ $center->name ?? old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Şehir</label>
                                    <input type="text" name="location_city" value="{{ $center->location_city ?? old('location_city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ülke</label>
                                    <input type="text" name="location_country" value="{{ $center->location_country ?? old('location_country') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Web Sitesi</label>
                                <input type="url" name="website_url" value="{{ $center->website_url ?? old('website_url') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Açıklama</label>
                                <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $center->description ?? old('description') }}</textarea>
                            </div>

                            <div class="flex items-center">
                                <input type="hidden" name="is_verified" value="0">
                                <input type="checkbox" name="is_verified" value="1" {{ ($center->is_verified ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label class="ml-2 block text-sm text-gray-900 font-bold">Resmi / Doğrulanmış Kaynak</label>
                            </div>

                            <div class="pt-4 border-t flex justify-end gap-3">
                                <a href="{{ route('admin.expert-centers.index') }}" class="px-4 py-2 border rounded text-sm hover:bg-gray-50">İptal</a>
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-700">Kaydet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
