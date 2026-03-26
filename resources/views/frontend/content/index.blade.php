@extends('frontend.layout')

@section('title', $title . ' - ALSHub')

@section('content')
    <div class="bg-gray-50 py-12 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $title }}</h1>
            <nav class="flex mt-2 text-sm text-gray-400" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-primary">Ana Sayfa</a></li>
                    <li>
                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </li>
                    <li class="text-gray-600 font-medium">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
        @if($contents->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                <p class="text-gray-400">Bu kategoride henüz içerik bulunmuyor.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($contents as $content)
                    @php
                        $type = strtolower(class_basename($content));
                        $type = match($type) {
                            'researcharticle' => 'research',
                            'clinicaltrial' => 'trial',
                            'drug' => 'drug',
                            'guideline' => 'guideline',
                            default => 'legacy'
                        };
                    @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col h-full relative">
                        @if(strtolower(class_basename($content)) === 'clinicaltrial')
                            @php
                                $rawStatus = $content->raw_payload_json['protocolSection']['statusModule']['overallStatus'] ?? '';
                                $statusConfig = match(strtolower($rawStatus)) {
                                    'recruiting' => ['label' => 'Kayıt Devam Ediyor', 'color' => 'bg-green-500 text-white'],
                                    'active, not recruiting' => ['label' => 'Aktif, Kayıt Kapalı', 'color' => 'bg-blue-500 text-white'],
                                    'not yet recruiting' => ['label' => 'Henüz Başlamadı', 'color' => 'bg-indigo-500 text-white'],
                                    'completed' => ['label' => 'Tamamlandı', 'color' => 'bg-gray-500 text-white'],
                                    'withdrawn' => ['label' => 'Geri Çekildi', 'color' => 'bg-red-500 text-white'],
                                    'terminated' => ['label' => 'Durduruldu', 'color' => 'bg-red-600 text-white'],
                                    'suspended' => ['label' => 'Askıya Alındı', 'color' => 'bg-yellow-500 text-white'],
                                    default => ['label' => $rawStatus ?: 'Bilinmiyor', 'color' => 'bg-gray-400 text-white']
                                };
                            @endphp
                            <div class="{{ $statusConfig['color'] }} text-[10px] font-black uppercase py-1 px-4 text-center tracking-widest">
                                {{ $statusConfig['label'] }}
                            </div>
                        @endif

                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex items-center gap-2 mb-4 text-xs">
                                <span class="bg-blue-50 text-primary font-bold px-2 py-0.5 rounded">{{ $content->source_label }}</span>
                                <span class="text-gray-300">•</span>
                                <span class="text-gray-400">{{ $content->publication_date ? $content->publication_date->format('d.m.Y') : $content->created_at->format('d.m.Y') }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4 line-clamp-2">
                                <a href="{{ $content->slug ? route('content.show', [$type, $content->slug]) : '#' }}" class="hover:text-primary">{{ $content->display_title }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-6">
                                {{ $content->display_summary }}
                            </p>
                            <div class="mt-auto">
                                <a href="{{ $content->slug ? route('content.show', [$type, $content->slug]) : '#' }}" class="text-primary font-bold text-sm block border-t border-gray-50 pt-4">Devamını Oku &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $contents->links() }}
            </div>
        @endif
    </div>
@endsection
