@extends('layouts.site')

@section('title', $category->name . ' - News Wrap')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-10 border-b pb-4 border-gray-200 dark:border-gray-800">
        <h1 class="text-4xl font-black uppercase tracking-tighter">{{ $category->name }}</h1>
    </div>

    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
            @foreach($articles as $article)
                <article class="group flex flex-col h-full">
                    @if($article->image)
                        <div class="aspect-w-16 aspect-h-9 mb-4 overflow-hidden bg-gray-100 dark:bg-gray-900 shadow-sm">
                            <a href="{{ route('articles.show', $article) }}">
                                <img src="{{ Storage::url($article->image) }}" class="object-cover w-full h-56 group-hover:scale-105 transition-transform duration-700 grayscale group-hover:grayscale-0">
                            </a>
                        </div>
                    @endif
                    
                    <div class="flex-1 flex flex-col">
                         <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-3 space-x-2 uppercase font-bold tracking-widest">
                            <span class="text-black dark:text-white bg-gray-200 dark:bg-gray-800 px-2 py-0.5 rounded-sm">{{ $article->category->name }}</span>
                            <span>&bull;</span>
                            <span>{{ $article->created_at->format('d.m.Y') }}</span>
                        </div>
                        
                        <h4 class="text-2xl font-bold mb-3 leading-tight group-hover:underline decoration-2 underline-offset-4">
                            <a href="{{ route('articles.show', $article) }}">
                                {{ $article->title }}
                            </a>
                        </h4>
                        
                        <div class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-4 prose prose-sm dark:prose-invert">
                            {!! Str::markdown(Str::limit(strip_tags($article->content), 150)) !!}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-20 text-gray-500">
            Bu kategoride henüz haber yok.
        </div>
    @endif
</div>
@endsection
