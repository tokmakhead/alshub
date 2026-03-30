<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Güvenilir Kaynak Tanımla') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900 font-sans">
                    <div class="mb-8 border-b pb-4">
                        <h3 class="text-lg font-bold text-blue-600 uppercase tracking-widest text-xs">Source-Trust First Registry</h3>
                        <p class="text-sm text-gray-400">Yeni bir resmi veri kaynağını sisteme entegre edin.</p>
                    </div>

                    <form action="{{ route('admin.sources.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Kaynak Seçimi / Adı</label>
                                <select name="source_name" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 bg-gray-50" required onchange="updateNotes(this)">
                                    <option value="">-- Kaynak Seçin --</option>
                                    <optgroup label="Akademik & Bilimsel">
                                        <option value="PubMed">PubMed (NIH/NLM)</option>
                                        <option value="Google Scholar">Google Scholar</option>
                                    </optgroup>
                                    <optgroup label="Klinik Kayıtlar">
                                        <option value="ClinicalTrials.gov">ClinicalTrials.gov</option>
                                        <option value="WHO ICTRP">WHO ICTRP</option>
                                    </optgroup>
                                    <optgroup label="İlaç Otoriteleri">
                                        <option value="OpenFDA">OpenFDA (US)</option>
                                        <option value="EMA">EMA (EU)</option>
                                    </optgroup>
                                    <optgroup label="Özel / Diğer">
                                        <option value="NEALS">NEALS Consortium</option>
                                        <option value="ENCALS">ENCALS Network</option>
                                        <option value="Guidelines">Klinik Rehberler (NICE/EAN)</option>
                                        <option value="Other">Diğer (Manuel Tanımla)</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Erişim Modu</label>
                                <select name="source_mode" id="source_mode" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 bg-gray-50" required shadow-sm>
                                    <option value="api">API Entegrasyonu (Official)</option>
                                    <option value="web_ingest">Web Ingest (Scraping/Feed)</option>
                                    <option value="manual">Manual Entry</option>
                                </select>
                            </div>

                            <div id="other_name_div" class="hidden">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Özel Kaynak İsmi</label>
                                <input type="text" id="other_name" class="w-full rounded-lg border-gray-200 text-sm p-2.5 bg-gray-50" placeholder="Kaynağın adını yazın...">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Logo URL (PNG/SVG Tavsiye Edilir)</label>
                                <input type="url" name="logo_url" class="w-full rounded-lg border-gray-200 text-sm p-2.5 bg-gray-50" placeholder="https://logo.png">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Resmi Web Sitesi (Tıklanınca Gidilecek Adres)</label>
                                <input type="url" name="official_url" class="w-full rounded-lg border-gray-200 text-sm p-2.5 bg-gray-50" placeholder="https://www.example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Notlar ve Entegrasyon Detayları</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-lg border-gray-200 text-sm p-3 bg-gray-50" placeholder="Kaynağın amacı, kapsamı ve teknik detayları hakkında notlar..."></textarea>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex gap-4 items-center">
                            <div class="bg-white p-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-xs text-blue-800 leading-relaxed font-medium">
                                <strong>Önemli:</strong> API modunu seçtiğinizde, sistem bu kaynağın resmi uç noktalarına bağlanmaya çalışacaktır. Web Ingest modu ise AI destekli veri tarama servisini aktif eder.
                            </p>
                        </div>

                        <div class="pt-6 flex justify-end gap-3 border-t">
                            <a href="{{ route('admin.sources.index') }}" class="px-6 py-2 border border-gray-200 rounded-lg text-xs font-bold text-gray-500 hover:bg-gray-50 transition uppercase tracking-widest">İptal</a>
                            <button type="submit" class="px-10 py-2 bg-blue-600 text-white rounded-lg text-xs font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition uppercase tracking-widest">
                                Kaynağı Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateNotes(select) {
            const val = select.value;
            const mode = document.getElementById('source_mode');
            const otherDiv = document.getElementById('other_name_div');
            const otherInput = document.getElementById('other_name');
            const notes = document.getElementById('notes');

            if (val === 'Other') {
                otherDiv.classList.remove('hidden');
                otherInput.required = true;
                otherInput.name = 'source_name';
                select.name = '_old_source_name';
            } else {
                otherDiv.classList.add('hidden');
                otherInput.required = false;
                otherInput.name = '_other_name';
                select.name = 'source_name';
            }

            // Auto-fallback mapping
            if (['PubMed', 'ClinicalTrials.gov', 'OpenFDA', 'WHO ICTRP'].includes(val)) {
                mode.value = 'api';
                notes.value = val + ' resmi API entegrasyonu.';
            } else if (['NEALS', 'ENCALS', 'MDA'].includes(val)) {
                mode.value = 'web_ingest';
                notes.value = val + ' kurumsal web sitesi taraması.';
            } else {
                mode.value = 'manual';
            }
        }
    </script>
</x-app-layout>
