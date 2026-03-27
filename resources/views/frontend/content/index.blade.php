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
                    <x-content-card :item="$content" />
                @endforeach
            </div>

            <div class="mt-12">
                {{ $contents->links() }}
            </div>
        @endif
    </div>
@endsection
