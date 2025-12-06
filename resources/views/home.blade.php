@extends('layouts.site')

@section('content')

<!-- 1. HERO SLIDER (Manşet) - Full Width on Mobile, Container on Desktop -->
@if($sliders->count() > 0)
    <div class="bg-gray-100 dark:bg-black pb-8">
        <div class="max-w-[1400px] mx-auto px-0 lg:px-4 pt-4">
             <div x-data="{ activeSlide: 0, slides: {{ $sliders->count() }} }" class="relative rounded-xl overflow-hidden shadow-2xl group">
                <div class="relative h-[400px] md:h-[550px] overflow-hidden">
                    @foreach($sliders as $index => $slider)
                        @php
                            $image = $slider->image ? Storage::url($slider->image) : ($slider->article ? Storage::url($slider->article->image) : 'https://placehold.co/1200x600?text=NewsWrap');
                            $title = $slider->title ?: ($slider->article ? $slider->article->title : '');
                            $link = $slider->link ?: ($slider->article ? route('articles.show', $slider->article) : '#');
                        @endphp
                        <a href="{{ $link }}" 
                           x-show="activeSlide === {{ $index }}" 
                           class="block absolute inset-0 transition-transform duration-700 ease-in-out transform"
                           x-transition:enter="transition ease-out duration-500"
                           x-transition:enter-start="opacity-0 scale-105"
                           x-transition:enter-end="opacity-100 scale-100"
                           x-transition:leave="transition ease-in duration-300"
                           x-transition:leave-start="opacity-100"
                           x-transition:leave-end="opacity-0"
                        >
                            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                            
                            <!-- Content -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12">
                                <span class="inline-block bg-white text-black text-[10px] md:text-xs font-black uppercase tracking-widest px-2 py-1 mb-3 rounded-sm">Manşet</span>
                                <h2 class="text-2xl md:text-5xl font-black text-white hover:text-gray-200 transition leading-tight shadow-md">{{ $title }}</h2>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <!-- Indicators -->
                <div class="absolute bottom-6 right-6 flex space-x-2 z-20">
                    <template x-for="i in slides">
                        <button @click="activeSlide = i - 1" :class="{ 'bg-white w-8': activeSlide === i - 1, 'bg-gray-500 w-2': activeSlide !== i - 1 }" class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
                
                <!-- Arrows -->
                <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black transition opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black transition opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>
@endif

<div class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8 py-12">
        
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- LEFT MAIN CONTENT -->
            <div class="lg:w-3/4">
                
                <!-- 2. SÜRMANŞET (Featured Grid) - 2x2 Grid usually or 1 big 2 small -->
                @if($featuredNews->count() > 0)
                    <div class="mb-16">
                        <h3 class="flex items-center text-2xl font-black uppercase tracking-tighter mb-6 border-l-4 border-black dark:border-white pl-4">
                            Gündem
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($featuredNews as $newsItem)
                                <article class="group bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition">
                                    <a href="{{ route('articles.show', $newsItem) }}" class="block relative overflow-hidden aspect-video">
                                        @if($newsItem->image)
                                            <img src="{{ Storage::url($newsItem->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <img src="https://placehold.co/600x400?text={{ Str::slug($newsItem->title) }}" class="w-full h-full object-cover">
                                        @endif
                                        <div class="absolute top-2 left-2 bg-black text-white text-[10px] font-bold uppercase px-2 py-1 rounded">{{ $newsItem->category->name }}</div>
                                    </a>
                                    <div class="p-4">
                                        <h4 class="text-lg font-bold leading-tight mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                            <a href="{{ route('articles.show', $newsItem) }}">{{ $newsItem->title }}</a>
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                            {{ Str::limit(strip_tags($newsItem->content), 80) }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 3. LATEST NEWS LIST (Compact) - "Haberler" -->
                <div class="mb-12">
                    <h3 class="flex items-center text-2xl font-black uppercase tracking-tighter mb-6 border-l-4 border-red-600 pl-4">
                        Son Eklenenler
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         @foreach($news as $article)
                            <article class="flex bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                                <a href="{{ route('articles.show', $article) }}" class="flex-shrink-0 w-24 h-24 md:w-32 md:h-32 rounded-md overflow-hidden mr-4">
                                    @if($article->image)
                                        <img src="{{ Storage::url($article->image) }}" class="w-full h-full object-cover hover:scale-105 transition">
                                    @else
                                        <img src="https://placehold.co/200x200?text=News" class="w-full h-full object-cover">
                                    @endif
                                </a>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="text-[10px] font-bold text-red-600 uppercase mb-1">{{ $article->category->name }}</div>
                                        <h4 class="text-base font-bold leading-snug hover:underline">
                                            <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                                        </h4>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-2 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $article->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </article>
                         @endforeach
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDEBAR -->
            <aside class="lg:w-1/4 space-y-8">
                
                <!-- Social / Subscribe -->
                <div class="bg-black text-white p-6 rounded-xl text-center">
                    <h4 class="font-black uppercase tracking-widest text-xl mb-2">Takip Et</h4>
                    <p class="text-gray-400 text-sm mb-4">Teknoloji dünyasından geri kalma!</p>
                    <div class="flex justify-center space-x-4">
                        @foreach(\App\Models\SocialMedia::where('is_active', true)->orderBy('order')->get() as $social)
                            <a href="{{ $social->url }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition transform hover:scale-110" style="background-color: {{ $social->color }}">
                                @if($social->icon)
                                    <i class="{{ $social->icon }}"></i>
                                @else
                                    <span class="font-bold text-xs">{{ substr($social->name, 0, 2) }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Köşe Yazıları (Vertical List) -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-black uppercase tracking-tighter mb-4 flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span> Köşe Yazıları
                    </h4>
                    <div class="space-y-6">
                        @forelse($posts as $post)
                            <article class="group">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold mr-2">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-xs font-bold text-gray-500 uppercase">{{ $post->user->name }}</span>
                                </div>
                                <h5 class="font-bold leading-tight group-hover:text-blue-600 transition">
                                    <a href="{{ route('articles.show', $post) }}">{{ $post->title }}</a>
                                </h5>
                            </article>
                        @empty
                            <p class="text-sm text-gray-500">Yazı yok.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Read / Trending (Static visual placeholder for now) -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                    <h4 class="text-lg font-black uppercase tracking-tighter mb-4">Çok Okunanlar</h4>
                    <ol class="list-decimal list-inside space-y-3 font-bold text-sm">
                        @foreach($news->take(5) as $popular)
                            <li class="pl-2 border-b border-gray-100 dark:border-gray-700 pb-2 last:border-0 hover:text-blue-600 cursor-pointer">
                                <a href="{{ route('articles.show', $popular) }}">{{ $popular->title }}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>

            </aside>

        </div>
    </div>
</div>

<!-- 4. VIDEO SECTION (Dark Mode Contrast) -->
<div class="bg-black text-white py-16">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <h3 class="text-3xl font-black uppercase tracking-tighter">Videolar & İnceleme</h3>
            <a href="#" class="text-gray-400 hover:text-white text-sm font-bold uppercase">Tüm Videolar</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($videos as $video)
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-lg aspect-video mb-3 border border-gray-800 bg-gray-900">
                         @if($video->image)
                             <img src="{{ Storage::url($video->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500 opacity-80 group-hover:opacity-100">
                         @else
                             <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/maxresdefault.jpg" class="w-full h-full object-cover group-hover:scale-110 transition duration-500 opacity-80 group-hover:opacity-100">
                         @endif
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-full flex items-center justify-center group-hover:bg-red-600 group-hover:scale-110 transition">
                                <svg class="w-5 h-5 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <a href="{{ route('videos.index') }}" class="absolute inset-0 z-10"></a>
                    </div>
                    <h4 class="font-bold leading-tight group-hover:text-gray-300 transition">{{ $video->title }}</h4>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
