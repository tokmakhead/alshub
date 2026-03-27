<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistem Sağlık Durumu (Monitoring)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($checks as $key => $check)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 
                        {{ $check['status'] === 'ok' ? 'border-green-500' : ($check['status'] === 'warning' ? 'border-yellow-500' : 'border-red-500') }}">
                        <div class="text-[10px] font-bold text-gray-400 uppercase mb-1 tracking-widest">{{ str_replace('_', ' ', $key) }}</div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-extrabold text-gray-800">
                                {{ $check['status'] === 'ok' ? 'SAĞLIKLI' : ($check['status'] === 'warning' ? 'DİKKAT' : 'KRİTİK') }}
                            </span>
                            <div class="h-2.5 w-2.5 rounded-full 
                                {{ $check['status'] === 'ok' ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : ($check['status'] === 'warning' ? 'bg-yellow-500' : 'bg-red-500 animate-pulse') }}">
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-gray-600 leading-relaxed font-medium">
                            {{ $check['message'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Sistem Bilgileri -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-6 border-b pb-2 flex items-center gap-2 text-sm uppercase">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Alt Yapı & Sunucu Bilgileri
                    </h3>
                    <div class="grid grid-cols-2 gap-y-4 text-sm">
                        <div class="text-gray-500">PHP Versiyonu:</div>
                        <div class="font-bold text-gray-800">{{ $systemInfo['php_version'] }}</div>
                        
                        <div class="text-gray-500">Laravel Sürümü:</div>
                        <div class="font-bold text-gray-800">{{ $systemInfo['laravel_version'] }}</div>
                        
                        <div class="text-gray-500">Çalışma Ortamı:</div>
                        <div class="inline-flex"><span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">{{ $systemInfo['environment'] }}</span></div>
                        
                        <div class="text-gray-500">Hata Ayıklama (Debug):</div>
                        <div class="font-bold {{ $systemInfo['debug_mode'] == 'Açık' ? 'text-red-600' : 'text-green-600' }}">{{ $systemInfo['debug_mode'] }}</div>
                    </div>
                </div>

                <!-- Zamanlanmış Görevler -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-6 border-b pb-2 flex items-center gap-2 text-sm uppercase">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Otomatik Veri Akış Durumu
                    </h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-gray-50 rounded border border-gray-100">
                            <div class="text-[10px] font-bold text-gray-400 uppercase mb-1">RSS & API Senkronizasyonu</div>
                            <div class="text-sm font-medium">Her gün 02:00 ve 14:00'te aktif.</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded border border-gray-100">
                            <div class="text-[10px] font-bold text-gray-400 uppercase mb-1">Mevcut Durum</div>
                            <div class="text-sm">Log kayıtlarına göre son başarılı işlem: <span class="font-bold text-blue-600">{{ $checks['scheduler']['message'] }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
