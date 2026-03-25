<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('İlaç Bilgi Kartı ve Onay Yönetimi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.drugs.update', $drug) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Genel Bilgiler -->
                            <div class="space-y-4 border-r pr-6">
                                <h3 class="font-bold border-b pb-2 text-blue-600">İlaç Kimliği</h3>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Generic Adı</label>
                                    <input type="text" name="generic_name" value="{{ $drug->generic_name }}" class="w-full rounded border-gray-300 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Ticari Adı (Brand)</label>
                                    <input type="text" name="brand_name" value="{{ $drug->brand_name }}" class="w-full rounded border-gray-300 text-sm">
                                </div>
                                
                                <h3 class="font-bold border-b pb-2 pt-4 text-purple-600">Bölgesel Onay Durumları (Tracking)</h3>
                                @foreach($drug->regionalStatuses as $status)
                                    <div class="p-3 border rounded mb-2 {{ $status->change_detected ? 'bg-red-50 border-red-200' : 'bg-gray-50' }}">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-sm">{{ $status->regulator_name }} ({{ $status->region }})</span>
                                            @if($status->change_detected)
                                                <span class="text-[10px] bg-red-600 text-white px-1 rounded animate-pulse">DEĞİŞİKLİK SAPTANDI</span>
                                            @endif
                                        </div>
                                        <div class="text-xs">Durum: {{ $status->approval_status }}</div>
                                        <div class="text-xs">Tarih: {{ $status->approval_date ? $status->approval_date->format('d.m.Y') : '-' }}</div>
                                        <div class="text-[10px] text-gray-400 mt-1">Indication: {{ Str::limit($status->indication, 100) }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Onay Ayarları -->
                            <div class="space-y-4">
                                <h3 class="font-bold border-b pb-2 text-green-600">Yayın ve Doğrulama</h3>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Doğrulama Katmanı (Tier)</label>
                                    <select name="verification_tier" class="w-full rounded border-gray-300 text-sm">
                                        <option value="1" {{ $drug->verification_tier == 1 ? 'selected' : '' }}>Tier 1 - Regulator Verified</option>
                                        <option value="2" {{ $drug->verification_tier == 2 ? 'selected' : '' }}>Tier 2 - Manufacturer Data</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Yayın Durumu</label>
                                    <select name="status" class="w-full rounded border-gray-300 text-sm">
                                        <option value="draft" {{ $drug->status == 'draft' ? 'selected' : '' }}>Taslak</option>
                                        <option value="in_review" {{ $drug->status == 'in_review' ? 'selected' : '' }}>İncelemede</option>
                                        <option value="approved" {{ $drug->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                        <option value="published" {{ $drug->status == 'published' ? 'selected' : '' }}>Yayınlandı</option>
                                    </select>
                                </div>

                                <div class="pt-4 flex justify-end gap-2">
                                    <a href="{{ route('admin.drugs.index') }}" class="px-4 py-2 border rounded text-sm hover:bg-gray-50">İptal</a>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-700">İlaç Verisini Güncelle</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
