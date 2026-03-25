<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistem Sağlık Durumu (Monitoring)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($checks as $key => $check)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 
                        {{ $check['status'] === 'ok' ? 'border-green-500' : ($check['status'] === 'warning' ? 'border-yellow-500' : 'border-red-500') }}">
                        <div class="text-xs font-bold text-gray-400 uppercase mb-1">{{ str_replace('_', ' ', $key) }}</div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold">
                                {{ $check['status'] === 'ok' ? 'SAĞLIKLI' : ($check['status'] === 'warning' ? 'UYARI' : 'KRİTİK') }}
                            </span>
                            <div class="h-3 w-3 rounded-full 
                                {{ $check['status'] === 'ok' ? 'bg-green-500 animate-pulse' : ($check['status'] === 'warning' ? 'bg-yellow-500' : 'bg-red-500') }}">
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-gray-600 italic">
                            {{ $check['message'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Operasyonel Detaylar</h3>
                <div class="text-sm space-y-2">
                    <p><strong>Otomatik Senkronizasyon (Cron):</strong> Her gün saat 02:00 ve 14:00'te çalışacak şekilde planlandı.</p>
                    <p><strong>Log Takibi:</strong> Son 24 saatteki hataları `Storage/logs` altından inceleyebilirsiniz.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
