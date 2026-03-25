<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kaynak Yönetimi') }} <span class="text-red-500 font-bold underline text-2xl">[V-9999-STABLE]</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('admin.sources.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Yeni Kaynak Ekle</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ad</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sources as $source)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $source->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $source->type }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $source->is_active ? 'Aktif' : 'Pasif' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div id="fetch-area-{{ $source->id }}">
                                            <button onclick="fetchSource({{ $source->id }})" style="background-color: #4f46e5; color: #ffffff; padding: 4px 12px; border-radius: 4px; font-weight: bold; font-size: 11px; cursor: pointer; border: none;">
                                                Şimdi Çek
                                            </button>
                                            
                                            @if($source->is_importing)
                                                <div class="mt-2 text-[10px] text-gray-500">
                                                    <a href="{{ url('admin/sources?reset_stuck=1') }}" style="color: #ef4444; text-decoration: underline;">Statü Sıfırla</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div id="progress-area-{{ $source->id }}" style="display:none" class="mt-2">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div id="progress-bar-{{ $source->id }}" style="background-color: #2563eb; width: 0%; height: 10px; border-radius: 10px;"></div>
                                            </div>
                                            <p id="progress-text-{{ $source->id }}" style="font-size: 10px; color: #4b5563; margin-top: 4px;">İşleniyor...</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium border-l">
                                        <a href="{{ route('admin.sources.edit', $source) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Düzenle</a>
                                        <form action="{{ route('admin.sources.destroy', $source) }}" method="POST" class="inline-block" onsubmit="return confirm('Emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Sil</button>
                                        </form>
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
            const btnArea = document.getElementById(`fetch-area-${id}`);
            const progressArea = document.getElementById(`progress-area-${id}`);
            const progressBar = document.getElementById(`progress-bar-${id}`);
            const progressText = document.getElementById(`progress-text-${id}`);

            if (btnArea) btnArea.style.display = 'none';
            if (progressArea) progressArea.style.display = 'block';
            if (progressBar) progressBar.style.width = '5%';
            if (progressText) progressText.innerText = 'RSS okunuyor...';

            // Start the fetch process via AJAX
            fetch(`{{ url('admin/sources') }}/${id}/fetch`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).catch(err => {
                console.error('Fetch error:', err);
                if (btnArea) btnArea.style.display = 'block';
                if (progressArea) progressArea.style.display = 'none';
            });

            // Start polling
            let pollCount = 0;
            const interval = setInterval(() => {
                pollCount++;
                fetch(`{{ url('admin/sources') }}/${id}/progress`)
                    .then(res => res.json())
                    .then(data => {
                        if (progressBar) progressBar.style.width = `${data.progress}%`;
                        if (progressText) progressText.innerText = data.message || 'İşleniyor...';

                        if (!data.is_importing && data.progress >= 100) {
                            clearInterval(interval);
                            if (progressText) progressText.innerText = 'Tamamlandı! Sayfa yenileniyor...';
                            setTimeout(() => location.reload(), 2000);
                        } else if (!data.is_importing && data.progress < 100 && data.message && data.message.includes('Hata')) {
                            clearInterval(interval);
                            alert('Hata: ' + data.message);
                            if (btnArea) btnArea.style.display = 'block';
                            if (progressArea) progressArea.style.display = 'none';
                        }
                        
                        // Safety timeout
                        if (pollCount > 150) {
                             clearInterval(interval);
                             if (btnArea) btnArea.style.display = 'block';
                             if (progressArea) progressArea.style.display = 'none';
                        }
                    })
                    .catch(err => {
                        console.error('Polling error:', err);
                    });
            }, 2000);
        }
    </script>
</x-app-layout>
