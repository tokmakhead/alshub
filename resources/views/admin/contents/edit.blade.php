<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('İçeriği İncele / Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gray-50 border-b">
                    <h3 class="text-lg font-bold">Orijinal Veri</h3>
                    <p class="text-sm text-gray-600">Kaynak: {{ $content->source->name ?? $content->source_name }} | <a href="{{ $content->source_url }}" target="_blank" class="text-blue-600 underline">Orijinal Link</a></p>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label class="font-bold block">Orijinal Başlık</label>
                        <div class="p-2 bg-gray-100 rounded">{{ $content->original_title }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="font-bold block">Orijinal Özet</label>
                        <div class="p-2 bg-gray-100 rounded">{!! nl2br(e($content->original_summary)) !!}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-blue-50 border-b flex justify-between items-center">
                    <h3 class="text-lg font-bold">Türkçe Çeviri ve Yayın Ayarları</h3>
                    <form action="{{ route('admin.contents.translate', $content) }}" method="POST">
                        @csrf
                        <button type="submit" style="background-color: #4f46e5; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer;">
                            ✨ AI ile Otomatik Çevir
                        </button>
                    </form>
                </div>
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.contents.update', $content) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 font-bold text-lg">Türkçe Başlık</label>
                            <input type="text" name="translated_title" value="{{ $content->translated_title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 font-bold text-lg">Türkçe Özet / İçerik</label>
                            <textarea name="translated_summary" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ $content->translated_summary }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Yayın Durumu</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="draft" {{ $content->status === 'draft' ? 'selected' : '' }}>Taslak</option>
                                    <option value="review" {{ $content->status === 'review' ? 'selected' : '' }}>İncelemede / Hazır</option>
                                    <option value="published" {{ $content->status === 'published' ? 'selected' : '' }}>Yayınla</option>
                                    <option value="archived" {{ $content->status === 'archived' ? 'selected' : '' }}>Arşivle</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold shadow-sm hover:bg-blue-700 transition">Güncelle ve Kaydet</button>
                            <a href="{{ route('admin.contents.index') }}" class="text-gray-600">Listeye Dön</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
