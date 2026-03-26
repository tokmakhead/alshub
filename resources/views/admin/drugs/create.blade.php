<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni İlaç Kaydı Oluştur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.drugs.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Sol Kolon: Ana Veriler -->
                            <div class="lg:col-span-2 space-y-6">
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Temel İlaç Kimliği
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-1">Generic Adı (Etken Madde) *</label>
                                            <input type="text" name="generic_name" required placeholder="Örn: Edaravone" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-1">Ticari Adı (Brand)</label>
                                            <input type="text" name="brand_name" placeholder="Örn: Radicava" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-1">Endikasyon / Hedef</label>
                                            <input type="text" name="indication" placeholder="Örn: ALS'de fonksiyonel kapasite kaybının yavaşlatılması" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary">
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50/30 p-6 rounded-2xl border border-blue-100 italic text-sm text-blue-900/60">
                                    <p>İlacı oluşturduktan sonra AI özetleme, finansal bilgiler ve detaylı açıklamaları düzenleme ekranından ekleyebilirsiniz.</p>
                                </div>
                            </div>

                            <!-- Sağ Kolon: Durum ve Onaylar -->
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                                    <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Yayın Ayarları
                                    </h3>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-2">Güven Katmanı (Tier)</label>
                                            <select name="verification_tier" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-sm">
                                                <option value="1">Tier 1 - Regulator Verified</option>
                                                <option value="2">Tier 2 - Scientific Peer Review</option>
                                                <option value="3">Tier 3 - Preliminary Data</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-black text-gray-500 uppercase mb-2">Başlangıç Durumu</label>
                                            <select name="status" class="w-full rounded-xl border-gray-200 focus:ring-primary focus:border-primary font-bold text-sm">
                                                <option value="draft">Taslak</option>
                                                <option value="published">Doğrudan Yayınla</option>
                                            </select>
                                        </div>

                                        <div class="space-y-3 pt-4 border-t border-gray-100">
                                             <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_fda" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span class="text-sm font-bold text-gray-700 group-hover:text-blue-600 transition-colors uppercase">FDA Onaylı</span>
                                            </label>
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_ema" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <span class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition-colors uppercase">EMA Onaylı</span>
                                            </label>
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="is_approved_titck" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                <span class="text-sm font-bold text-gray-700 group-hover:text-red-600 transition-colors uppercase">TİTCK Onaylı (Türkiye)</span>
                                            </label>
                                        </div>

                                        <div class="pt-6">
                                            <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-4 font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg transition-all">
                                                İLAÇ KAYDINI OLUŞTUR
                                            </button>
                                            <a href="{{ route('admin.drugs.index') }}" class="block text-center mt-4 text-xs font-bold text-gray-400 hover:text-gray-600 uppercase">İptal ve Geri Dön</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
