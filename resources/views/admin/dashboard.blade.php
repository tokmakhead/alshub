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
                    <h3 class="text-lg font-bold mb-4">Hızlı Menü</h3>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.contents.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">İçerikleri Yönet</a>
                        <a href="{{ route('admin.sources.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Kaynakları Yönet</a>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ route('admin.sources.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Kaynakları Yönet
                        </a>
                        <a href="{{ route('admin.contents.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                            İçerikleri İncele
                        </a>
                        <a href="{{ route('admin.logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 transition">
                            Sistem Logları
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
