<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Klinik Rehber Ekle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.guidelines.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kurum / Kaynak Organizasyon</label>
                                <input type="text" name="source_org" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Örn: NICE, AAN, EFNS...">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Orijinal Başlık (İngilizce)</label>
                                <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Rehberin orijinal başlığını girin...">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Orijinal Özet / Açıklama (Opsiyonel)</label>
                                <textarea name="summary_original" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="AI özeti için buraya orijinal metni yapıştırabilirsiniz..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Başlangıç Durumu</label>
                                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="draft">Taslak</option>
                                        <option value="in_review">İncelemede</option>
                                        <option value="published">Yayınla</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Güven Katmanı</label>
                                    <select name="verification_tier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="1">Tier 1 (Resmi Kurum)</option>
                                        <option value="2">Tier 2 (Hastane/Dergi)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                                <a href="{{ route('admin.guidelines.index') }}" class="text-sm text-gray-600 hover:text-gray-900">İptal</a>
                                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Rehber Oluştur ve Detaylara Git
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
