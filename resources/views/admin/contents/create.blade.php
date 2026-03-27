<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Haber/İçerik Ekle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.contents.store') }}" method="POST" class="p-6">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                            <strong>Lütfen hataları düzeltin:</strong>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- SOL KOLON: Orijinal Metinler ve Kaynak -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Orijinal (Kaynak) Bilgileri</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Kaynak Kurum *</label>
                                <select name="source_id" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Seçiniz</option>
                                    @foreach($sources as $source)
                                        <option value="{{ $source->id }}" {{ old('source_id') == $source->id ? 'selected' : '' }}>
                                            {{ $source->source_name }} ({{ strtoupper($source->source_mode) }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">WHO, NEALS, vb. API dışı kurumları buradan etiketleyebilirsiniz.</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Orijinal Link (Source URL)</label>
                                <input type="url" name="source_url" value="{{ old('source_url') }}" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://www.who.int/...">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Orijinal Yayın Tarihi</label>
                                <input type="date" name="source_published_at" value="{{ old('source_published_at') }}" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Bu makale o sitede ilk ne zaman yayınlandı?</p>
                            </div>

                            <hr class="my-6 border-gray-300">

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">İçerik Türü *</label>
                                <select name="type" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Makale (Article)</option>
                                    <option value="news" {{ old('type') == 'news' ? 'selected' : '' }}>Haber (News)</option>
                                    <option value="publication" {{ old('type') == 'publication' ? 'selected' : '' }}>Özet Yayın</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Orijinal Başlık (İngilizce) *</label>
                                <input type="text" name="original_title" value="{{ old('original_title') }}" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Orijinal Özet (İngilizce)</label>
                                <textarea name="original_summary" rows="3" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">{{ old('original_summary') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Orijinal İçerik (Full Metin)</label>
                                <textarea name="original_content" rows="6" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">{{ old('original_content') }}</textarea>
                            </div>
                        </div>

                        <!-- SAĞ KOLON: Türkçe Çeviriler ve Yayın -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <h3 class="text-lg font-bold text-indigo-700 mb-4 border-b pb-2 flex justify-between items-center">
                                <span>Türkçe Çeviri Bilgileri</span>
                                <span class="bg-indigo-50 text-indigo-600 text-[10px] px-2 py-1 rounded">TR ZORUNLU</span>
                            </h3>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Türkçe Başlık *</label>
                                <input type="text" name="translated_title" value="{{ old('translated_title') }}" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500" required>
                                <p class="text-[11px] text-gray-400 mt-1">Sitede görünecek ana başlık budur.</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Türkçe Özet (Vitrin Metni)</label>
                                <textarea name="translated_summary" rows="4" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">{{ old('translated_summary') }}</textarea>
                                <p class="text-[11px] text-gray-400 mt-1">Anasayfadaki Grid (Kart) gösteriminde bu kısım görünecektir.</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Türkçe Tam İçerik (Opsiyonel)</label>
                                <textarea name="translated_content" rows="8" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">{{ old('translated_content') }}</textarea>
                                <p class="text-[11px] text-gray-500 italic mt-1 font-medium">İpucu: Eğer orijinal metni girer, Türkçe tarafları boş veya kısa bırakıp "Taslak" olarak kaydedersen; Kayıttan sonra tablodaki "AI" butonuyla otomatik tıp çevirisi yaptırabilirsin!</p>
                            </div>

                            <div class="mt-8 bg-gray-50 p-4 border rounded">
                                <label class="block text-sm font-bold text-gray-800 mb-2">Yayın Durumu</label>
                                <select name="status" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 font-bold" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Taslak (Kaydet ve AI Çevirisi Bekle)</option>
                                    <option value="review" {{ old('status') == 'review' ? 'selected' : '' }}>İnceleme Bekliyor</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>YAYINLA (Canlıya Al)</option>
                                </select>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <a href="{{ route('admin.contents.index') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded font-medium hover:bg-gray-50">İptal</a>
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-bold hover:bg-indigo-700 shadow-md">
                                    Kaydet & Gönder
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
