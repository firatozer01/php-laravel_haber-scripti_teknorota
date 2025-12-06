@extends('layouts.site')

@section('content')
<article class="min-h-screen bg-white dark:bg-black">
    <!-- Hero Image & Title -->
    <div class="relative w-full h-[50vh] md:h-[60vh] bg-gray-900">
        @if($article->image)
            <img src="{{ Storage::url($article->image) }}" class="w-full h-full object-cover opacity-60">
        @else
            <img src="https://placehold.co/1200x600?text={{ Str::slug($article->title) }}" class="w-full h-full object-cover opacity-60">
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 max-w-7xl mx-auto">
            <a href="{{ route('categories.show', $article->category) }}" class="inline-block bg-blue-600 text-white text-xs font-bold uppercase px-3 py-1 rounded-sm mb-4 hover:bg-blue-700 transition">
                {{ $article->category->name }}
            </a>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight uppercase tracking-tighter mb-4 shadow-sm">
                {{ $article->title }}
            </h1>
            <div class="flex items-center text-gray-300 text-sm font-bold uppercase tracking-wider">
                @if($article->user)
                    <div class="flex items-center mr-6">
                         @if($article->user->avatar)
                             <img src="{{ Storage::url($article->user->avatar) }}" class="w-8 h-8 rounded-full mr-2 object-cover border border-white/20">
                         @else
                            <div class="w-8 h-8 rounded-full bg-white text-black flex items-center justify-center font-bold mr-2 text-xs">
                                {{ substr($article->user->name, 0, 1) }}
                            </div>
                         @endif
                        <span>{{ $article->user->name }}</span>
                    </div>
                @endif
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $article->created_at->format('d.m.Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="prose prose-lg prose-invert md:prose-xl max-w-none text-gray-800 dark:text-gray-300 leading-relaxed font-serif">
            {!! $article->content !!}
        </div>
        
        <!-- Share / Tags -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
             <div class="flex items-center justify-between">
                 <div class="text-sm font-bold uppercase text-gray-500">Paylaş</div>
                 <div class="flex space-x-4">
                     <!-- Social Placeholders -->
                     <button class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                         <span class="sr-only">Facebook</span>
                         <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                     </button>
                     <button class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-blue-400 hover:text-white transition">
                         <span class="sr-only">Twitter</span>
                         <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                     </button>
                 </div>
             </div>
        </div>
    </div>
    
    <!-- Comments Section -->
    <div class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-black uppercase tracking-tighter mb-8 flex items-center">
                Yorumlar <span class="ml-3 text-sm bg-black text-white dark:bg-white dark:text-black px-2 py-1 rounded-full">{{ $article->comments->where('is_approved', true)->count() }}</span>
            </h3>

            @auth
                <form action="{{ route('articles.comment', $article) }}" method="POST" class="mb-12 bg-white dark:bg-black p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-800">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold uppercase mb-2">Yorum Yaz</label>
                        <textarea name="content" rows="3" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg focus:ring-black dark:focus:ring-white p-4 transition" placeholder="Düşüncelerinizi paylaşın..." required></textarea>
                    </div>
                    <button type="submit" class="bg-black text-white dark:bg-white dark:text-black px-6 py-2 rounded font-bold uppercase tracking-wider hover:opacity-80 transition">Gönder</button>
                </form>
            @else
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 p-6 rounded-lg mb-12 text-center">
                    <p class="font-bold text-blue-800 dark:text-blue-300">Yorum yapabilmek için <a href="{{ route('login') }}" class="underline hover:text-blue-600">giriş yapmalısınız</a>.</p>
                </div>
            @endauth

            <div class="space-y-8">
                @foreach($article->comments->where('parent_id', null)->where('is_approved', true) as $comment)
                     @include('partials.comment-replies', ['comment' => $comment, 'article' => $article])
                @endforeach
            </div>
        </div>
    </div>
</article>
@endsection
