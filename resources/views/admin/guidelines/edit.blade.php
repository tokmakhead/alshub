<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klinik Rehber İnceleme') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.guidelines.update', $guideline) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kaynak Verisi -->
                            <div class="space-y-4 border-r pr-6">
                                <h3 class="font-bold border-b pb-2 text-blue-600">Orijinal Rehber Bilgisi</h3>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Kurum</label>
                                    <div class="p-2 bg-gray-50 border rounded text-sm font-bold">{{ $guideline->source_org }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Orijinal Başlık</label>
                                    <input type="text" name="title" value="{{ $guideline->title }}" class="w-full rounded border-gray-300 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Özet (Orijinal)</label>
                                    <div class="p-2 bg-gray-50 border rounded text-xs h-60 overflow-y-auto">{{ $guideline->summary_original }}</div>
                                </div>
                                @if($guideline->pdf_url)
                                    <div>
                                        <a href="{{ $guideline->pdf_url }}" target="_blank" class="text-blue-600 underline text-sm">PDF Kaynağını Görüntüle</a>
                                    </div>
                                @endif
                            </div>

                            <!-- Düzenleme / Çeviri -->
                            <div class="space-y-4">
                                <h3 class="font-bold border-b pb-2 text-green-600">Editör Çalışma Alanı (Türkçe / Basitleştirilmiş)</h3>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Türkçe Özet ve Basitleştirilmiş Anlatım</label>
                                    <textarea name="summary_tr" rows="15" class="w-full rounded border-gray-300 text-sm" placeholder="AI tarafından hazırlanan veya manuel girilen rehber özeti...">{{ $guideline->summary_tr }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Onay Durumu</label>
                                        <select name="status" class="w-full rounded border-gray-300 text-sm">
                                            <option value="draft" {{ $guideline->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                            <option value="in_review" {{ $guideline->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                            <option value="approved" {{ $guideline->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                            <option value="published" {{ $guideline->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                            <option value="rejected" {{ $guideline->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Güven Tier</label>
                                        <select name="verification_tier" class="w-full rounded border-gray-300 text-sm">
                                            <option value="1" {{ $guideline->verification_tier == 1 ? 'selected' : '' }}>Tier 1 (Resmi Kurum)</option>
                                            <option value="2" {{ $guideline->verification_tier == 2 ? 'selected' : '' }}>Tier 2 (Hastane/Dergi)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2">
                                    <a href="{{ route('admin.guidelines.index') }}" class="px-4 py-2 border rounded text-sm hover:bg-gray-50">İptal</a>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-700">Güncelle ve Kaydet</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
