@extends('layouts.site')

@section('title', 'Videolar - News Wrap')

@section('content')
<div class="bg-black text-white min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-10 border-b border-gray-800 pb-4">
            <h1 class="text-4xl font-black uppercase tracking-tighter">Videolar</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($videos as $video)
                <div class="group">
                    <div class="relative overflow-hidden rounded-lg aspect-video mb-4 border border-gray-800 bg-gray-900">
                        <iframe 
                            src="https://www.youtube.com/embed/{{ $video->youtube_id }}" 
                            title="{{ $video->title }}"
                            class="absolute inset-0 w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    <h3 class="text-xl font-bold leading-tight group-hover:text-gray-300 transition">{{ $video->title }}</h3>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 text-gray-500">
                    Henüz video eklenmemiş.
                </div>
            @endforelse
        </div>
        
        <div class="mt-12">
            {{ $videos->links() }}
        </div>
    </div>
</div>
@endsection
