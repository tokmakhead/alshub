<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kaynak Düzenle') }}: {{ $source->source_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900 font-sans">
                    <div class="mb-8 border-b pb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-blue-600 uppercase tracking-widest text-xs">Kaynak Ayarları</h3>
                            <p class="text-sm text-gray-400">Entegrasyon parametrelerini ve çalışma durumunu güncelleyin.</p>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-bold italic">ID: #{{ $source->id }}</span>
                    </div>

                    <form action="{{ route('admin.sources.update', $source->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Kaynak Adı</label>
                                <input type="text" name="source_name" value="{{ old('source_name', $source->source_name) }}" class="w-full rounded-lg border-gray-200 text-sm font-bold p-2.5 bg-gray-50" required>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Erişim Modu</label>
                                <select name="source_mode" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 bg-gray-50" required shadow-sm>
                                    <option value="api" {{ $source->source_mode == 'api' ? 'selected' : '' }}>API Entegrasyonu (Official)</option>
                                    <option value="web_ingest" {{ $source->source_mode == 'web_ingest' ? 'selected' : '' }}>Web Ingest (Scraping/Feed)</option>
                                    <option value="manual" {{ $source->source_mode == 'manual' ? 'selected' : '' }}>Manual Entry</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Notlar</label>
                            <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-200 text-sm p-3 bg-gray-50">{{ $source->notes }}</textarea>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-gray-700">Çalışma Durumu</h4>
                                <p class="text-xs text-gray-400 font-medium">Bu kaynak şu an aktif mi?</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold {{ $source->is_enabled ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $source->is_enabled ? 'AKTİF' : 'PASİF' }}
                                </span>
                                <input type="hidden" name="is_enabled" value="0">
                                <input type="checkbox" name="is_enabled" value="1" {{ $source->is_enabled ? 'checked' : '' }} 
                                    class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 transition cursor-pointer">
                            </div>
                        </div>

                        <div class="pt-6 flex justify-between items-center border-t">
                            <div class="text-[10px] text-gray-400 font-medium">
                                Son Senkronizasyon: {{ $source->last_successful_sync ? $source->last_successful_sync->format('d.m.Y H:i') : 'Hiç yok' }}
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('admin.sources.index') }}" class="px-6 py-2 border border-gray-200 rounded-lg text-xs font-bold text-gray-500 hover:bg-gray-50 transition uppercase tracking-widest">İptal</a>
                                <button type="submit" class="px-10 py-2 bg-blue-600 text-white rounded-lg text-xs font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition uppercase tracking-widest">
                                    Değişiklikleri Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
