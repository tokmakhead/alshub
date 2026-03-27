<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kaynak Yönetimi (Source-Trust Registry)') }}
            </h2>
            <div class="flex items-center gap-4">
                <p class="text-xs text-gray-500 italic">Resmi API ve Kurumsal Web Kaynakları (RSS Devre Dışı)</p>
                <a href="{{ route('admin.sources.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Yeni Kaynak Ekle</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kaynak Adı / Notlar</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Erişim Modu</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Son Senkronizasyon</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sources as $source)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="text-sm font-bold text-gray-900">{{ $source->source_name }}</div>
                                            <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-tighter">
                                                {{ $source->target_module }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $source->notes }}</div>
                                    </td>
                                        @php
                                            $modeLabel = match($source->source_mode) {
                                                'api' => $isAutomated ? 'ROBOT (API)' : 'PASİF API',
                                                'web_ingest' => 'WEB TAKİBİ',
                                                'manual' => 'ELLE GİRİŞ',
                                                default => strtoupper($source->source_mode)
                                            };
                                            $modeColor = match($source->source_mode) {
                                                'api' => $isAutomated ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-500 border border-gray-200',
                                                'web_ingest' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                                                'manual' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-bold rounded {{ $modeColor }}">
                                            {{ $modeLabel }}
                                        </span>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $source->is_enabled ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $source->is_enabled ? 'AKTİF' : 'PASİF' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $source->last_successful_sync ? $source->last_successful_sync->format('d.m.Y H:i') : 'Hiç yok' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right">
                                        <div class="flex justify-end gap-2">
                                            @php
                                                $automatedSources = ['PubMed', 'ClinicalTrials.gov', 'OpenFDA'];
                                                $isAutomated = in_array($source->source_name, $automatedSources);
                                            @endphp
                                            @if($source->source_mode != 'manual')
                                                @if($isAutomated)
                                                    <button onclick="fetchSource({{ $source->id }})" class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-2 py-1 rounded text-xs transition duration-150 ease-in-out font-bold">
                                                        Şimdi Çek
                                                    </button>
                                                @else
                                                    <button disabled title="Bu kurum için aktif bir API robotu kodlanmamıştır. Sağlık içeriklerini manuel eklerken 'Kimlik/Etiket' (Source Reference) olarak kullanılır." class="text-gray-400 bg-gray-50 border border-gray-200 px-2 py-1 rounded text-xs cursor-not-allowed">
                                                        Manuel Kaynak
                                                    </button>
                                                @endif
                                            @endif
                                            <a href="{{ route('admin.sources.edit', $source->id) }}" class="text-gray-600 hover:text-gray-900 border border-gray-400 px-2 py-1 rounded text-xs transition duration-150 ease-in-out">
                                                Düzenle
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function fetchSource(id) {
            Swal.fire({
                title: 'Veri Çekiliyor...',
                text: 'Resmi API üzerinden veriler normalize ediliyor ve doğrulanıyor. Bu işlem 10-20 saniye sürebilir.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`{{ url('admin/sources') }}/${id}/fetch`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: data.message,
                        timer: 2000
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Hata!', data.message, 'error');
                }
            })
            .catch(err => {
                Swal.fire('Hata!', 'Sunucu ile iletişim kurulamadı.', 'error');
            });
        }
    </script>
</x-app-layout>
