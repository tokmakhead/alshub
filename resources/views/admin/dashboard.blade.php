<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 truncate">Toplam İçerik</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_content'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-blue-500 truncate">Taslak</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['drafts'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-400">
                    <div class="text-sm font-medium text-yellow-500 truncate">Onay Bekleyen</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['review'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-400">
                    <div class="text-sm font-medium text-green-500 truncate">Yayınlanan</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['published'] }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Hızlı Erişim</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="{{ route('admin.sources.index') }}" class="flex items-center justify-center p-6 bg-indigo-50 border border-indigo-100 rounded-2xl text-indigo-700 font-bold hover:bg-indigo-100 transition shadow-sm">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Kaynakları Yönet
                        </a>
                        <a href="{{ route('admin.contents.index') }}" class="flex items-center justify-center p-6 bg-green-50 border border-green-100 rounded-2xl text-green-700 font-bold hover:bg-green-100 transition shadow-sm">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            İçerikleri İncele
                        </a>
                        <a href="{{ route('admin.logs.index') }}" class="flex items-center justify-center p-6 bg-gray-50 border border-gray-100 rounded-2xl text-gray-700 font-bold hover:bg-gray-100 transition shadow-sm">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            İşlem Günlükleri
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
