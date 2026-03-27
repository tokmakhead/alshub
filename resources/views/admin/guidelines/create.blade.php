<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Klinik Rehber Ekle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.guidelines.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-8">
                            <!-- Kaynak Bilgileri Bölümü -->
                            <div>
                                <h3 class="font-bold border-b pb-2 text-blue-600 mb-4 uppercase text-xs tracking-wider">Rehber Kaynak Bilgileri</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kurum / Kaynak Organizasyon</label>
                                            <input type="text" name="source_org" required 
                                                   class="w-full rounded border-gray-300 text-sm focus:ring-indigo-500" 
                                                   placeholder="Örn: NICE, AAN, EFNS...">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Orijinal Başlık (İngilizce)</label>
                                            <input type="text" name="title" required 
                                                   class="w-full rounded border-gray-300 text-sm focus:ring-indigo-500" 
                                                   placeholder="Rehberin orijinal başlığını girin...">
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Onay Durumu</label>
                                            <select name="status" class="w-full rounded border-gray-300 text-sm focus:ring-indigo-500">
                                                <option value="draft">Taslak</option>
                                                <option value="in_review">İncelemede</option>
                                                <option value="published" selected>Yayınla</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Güven Katmanı</label>
                                            <select name="verification_tier" class="w-full rounded border-gray-300 text-sm focus:ring-indigo-500">
                                                <option value="1">Tier 1 (Resmi Kurum)</option>
                                                <option value="2">Tier 2 (Hastane/Dergi)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- İçerik Başlangıç Bölümü -->
                            <div>
                                <h3 class="font-bold border-b pb-2 text-blue-600 mb-4 uppercase text-xs tracking-wider">İçerik ve Özet Hazırlığı</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Orijinal Özet / Açıklama (Opsiyonel)</label>
                                        <p class="text-[10px] text-gray-400 mb-2 italic">* Bu metin, kaydedildikten sonra düzenleme ekranında AI tarafından Türkçeleştirmek ve özetlemek için kaynak olarak kullanılacaktır.</p>
                                        <textarea name="summary_original" rows="8" 
                                                  class="w-full rounded border-gray-300 text-sm focus:ring-indigo-500" 
                                                  placeholder="AI özeti için buraya orijinal metni yapıştırabilirsiniz..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Butonlar -->
                            <div class="flex items-center justify-end gap-3 pt-6 border-t font-bold">
                                <a href="{{ route('admin.guidelines.index') }}" class="px-6 py-2 border rounded text-sm hover:bg-gray-50 transition">İptal</a>
                                <button type="submit" 
                                        class="px-6 py-2 rounded text-sm text-white shadow-md transition"
                                        style="background-color: #6366f1 !important; cursor: pointer;">
                                    Rehber Oluştur ve AI Özete Geç
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
