<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kaynak Yönetimi') }}
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
                                        @if($source->is_active)
                                            <div id="source-actions-{{ $source->id }}">
                                                <button onclick="fetchSource({{ $source->id }})" class="bg-indigo-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-indigo-700">Şimdi Çek</button>
                                            </div>
                                            <div id="source-progress-container-{{ $source->id }}" class="hidden mt-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div id="source-progress-bar-{{ $source->id }}" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                                                </div>
                                                <p id="source-progress-text-{{ $source->id }}" class="text-[10px] text-gray-600 mt-1">Başlatılıyor...</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
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
            const btnContainer = document.getElementById(`source-actions-${id}`);
            const progressContainer = document.getElementById(`source-progress-container-${id}`);
            const progressBar = document.getElementById(`source-progress-bar-${id}`);
            const progressText = document.getElementById(`source-progress-text-${id}`);

            btnContainer.classList.add('hidden');
            progressContainer.classList.remove('hidden');

            // Start the fetch process via AJAX
            fetch(`{{ url('admin/sources') }}/${id}/fetch`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            // Start polling
            const interval = setInterval(() => {
                fetch(`{{ url('admin/sources') }}/${id}/progress`)
                    .then(res => res.json())
                    .then(data => {
                        progressBar.style.width = `${data.progress}%`;
                        progressText.innerText = data.message || 'İşleniyor...';

                        if (!data.is_importing && data.progress >= 100) {
                            clearInterval(interval);
                            progressText.innerText = 'Tamamlandı! Sayfa yenileniyor...';
                            setTimeout(() => location.reload(), 1500);
                        } else if (!data.is_importing && data.progress < 100 && data.message.includes('Hata')) {
                            clearInterval(interval);
                            btnContainer.classList.remove('hidden');
                        }
                    });
            }, 2000);
        }
    </script>
</x-app-layout>
```
