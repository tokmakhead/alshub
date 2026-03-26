<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kaynak Yönetimi (Source-Trust Registry)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <p class="text-sm text-gray-600">Sistem önceliği: Resmi API ve Kurumsal Web Kaynakları (RSS Devre Dışı)</p>
                <a href="{{ route('admin.sources.create') }}" class="btn btn-primary btn-sm">Yeni Kaynak Ekle</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kaynak Adı</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Erişim Modu</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Durum</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Son Senkronizasyon</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksiyon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $source->source_name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $source->notes }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-{{ $source->source_mode == 'api' ? 'success' : ($source->source_mode == 'manual' ? 'info' : 'warning') }}">
                                            {{ strtoupper($source->source_mode) }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-{{ $source->is_enabled ? 'success' : 'secondary' }}">
                                            {{ $source->is_enabled ? 'AKTİF' : 'PASİF' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $source->last_successful_sync ? $source->last_successful_sync->format('d.m.Y H:i') : 'Hiç yok' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($source->source_mode != 'manual')
                                            <button onclick="fetchSource({{ $source->id }})" class="btn btn-link text-primary text-gradient px-3 mb-0">
                                                <i class="fas fa-sync me-2"></i>Şimdi Çek
                                            </button>
                                        @else
                                            <span class="text-xs text-secondary">Manuel Giriş</span>
                                        @endif
                                        <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('admin.sources.edit', $source->id) }}">
                                            <i class="fas fa-pencil-alt text-dark me-2"></i>Düzenle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetchSource(id) {
            if(!confirm('Resmi API üzerinden veri çekme işlemi başlatılsın mı?')) return;
            
            Swal.fire({
                title: 'Veri Çekiliyor...',
                text: 'Resmi API üzerinden veriler normalize ediliyor ve doğrulanıyor.',
                allowOutsideClick: false,
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
                    Swal.fire('Başarılı!', data.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Hata!', data.message, 'error');
                }
            })
            .catch(err => {
                Swal.fire('Hata!', 'Sunucu ile iletişim saptanamadı.', 'error');
            });
        }
    </script>
</x-app-layout>
