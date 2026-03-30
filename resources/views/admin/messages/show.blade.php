<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mesaj Detayı: #{{ $message->id }}
            </h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm text-gray-400 hover:text-gray-900 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Mesaj Listesine Dön
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 p-10 md:p-14">
                <div class="flex flex-wrap justify-between items-start gap-6 mb-12 border-b pb-8">
                    <div>
                        <div class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-2">Gönderen Kişi</div>
                        <h1 class="text-3xl font-black text-gray-900 mb-2">{{ $message->name }}</h1>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500 font-medium">{{ $message->email }}</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="text-sm text-gray-500 font-medium">{{ $message->phone ?: 'Telefon belirtilmedi' }}</span>
                        </div>
                    </div>
                    @php
                        $statusColor = match($message->status) {
                            'unread' => 'bg-red-100 text-red-800',
                            'read' => 'bg-green-100 text-green-800',
                            'archived' => 'bg-gray-100 text-gray-800',
                            default => 'bg-gray-100 text-gray-500'
                        };
                    @endphp
                    <span class="px-4 py-1.5 text-xs font-black uppercase tracking-widest rounded-full {{ $statusColor }}">
                        {{ $message->status_label }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Konu</div>
                        <div class="text-lg font-bold text-gray-900 italic">"{{ $message->subject }}"</div>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Gönderim Tarihi</div>
                        <div class="text-lg font-bold text-gray-900">{{ $message->created_at->format('d F Y - H:i') }}</div>
                    </div>
                </div>

                <div class="mb-12">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Mesaj İçeriği</div>
                    <div class="bg-blue-50/30 p-8 rounded-[2rem] text-gray-800 leading-relaxed text-lg font-medium whitespace-pre-wrap min-h-[200px] border border-blue-50">
                        {{ $message->message }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 p-6 rounded-2xl border border-gray-100 mb-12">
                     <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">IP Adresi</span>
                        <code class="text-xs font-bold text-blue-600">{{ $message->ip_address }}</code>
                    </div>
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Tarayıcı Bilgisi</span>
                        <div class="text-[10px] text-gray-500 truncate" title="{{ $message->user_agent }}">{{ $message->user_agent }}</div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 pt-8 border-t">
                    <form action="{{ route('admin.messages.archive', $message->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-gray-100 text-gray-600 px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition active:scale-95">
                            Mesajı Arşivle
                        </button>
                    </form>
                    <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Silmek istediğine emin misin?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-50 text-red-600 border border-red-100 px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition active:scale-95">
                            Mesajı Sil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
