@extends('layouts.site')

@section('title', $question->title . ' - Soru & Cevap')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Question -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-8 rounded-xl shadow-lg mb-12">
        <div class="flex items-center space-x-2 text-xs text-gray-500 mb-4 uppercase font-bold tracking-wider">
            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 px-2 py-1 rounded">Soru</span>
            <span>&bull;</span>
            <span class="text-black dark:text-white">{{ $question->user->name }}</span>
            <span>&bull;</span>
            <span>{{ $question->created_at->diffForHumans() }}</span>
        </div>
        
        <h1 class="text-3xl sm:text-4xl font-black uppercase tracking-tight mb-6">{{ $question->title }}</h1>
        
        <div class="prose prose-lg prose-gray dark:prose-invert max-w-none">
            {!! $question->content !!}
        </div>
    </div>

    <!-- Answers (Using same comment system) -->
    <section class="mt-12">
        <h3 class="text-2xl font-black uppercase tracking-tight mb-8">Cevaplar ({{ $comments->count() }})</h3>
        
        @auth
            <!-- Reuse generic comment store route but we need to adapt it. 
                 Wait, existing route is for Articles. We need a route for Question comments.
                 Or we can be smart and use a polymorphic route?
                 For now, let's create a specific route for questions comments in QuestionController.
            -->
            <form action="{{ route('questions.comment', $question) }}" method="POST" class="mb-10">
                @csrf
                <div class="mb-4">
                    <label class="block font-bold uppercase text-xs mb-2">Cevap Yaz</label>
                    <textarea name="content" rows="4" class="w-full bg-white dark:bg-black border border-gray-300 dark:border-gray-700 p-4 focus:ring-2 focus:ring-black dark:focus:ring-white outline-none transition rounded-lg" placeholder="Cevabınızı yazın..." required></textarea>
                </div>
                <button type="submit" class="px-6 py-3 bg-black text-white dark:bg-white dark:text-black font-bold uppercase tracking-wider hover:opacity-80 transition rounded-lg">Gönder</button>
            </form>
        @else
            <div class="mb-10 p-4 bg-gray-200 dark:bg-gray-800 text-center rounded-lg">
                Cevap yazabilmek için <a href="{{ route('login') }}" class="underline font-bold">giriş yapmalısınız</a>.
            </div>
        @endauth

        <div class="space-y-8">
            @if($comments->count() > 0)
                <!-- We need to update the partial to support Questions route for nested replies -->
                <!-- Ideally pass the route name to the partial? Or just duplicate partial for simplicity? -->
                <!-- Passing variables is cleaner. -->
                @include('partials.question-replies', ['comments' => $comments, 'question' => $question])
            @else
                <p class="text-gray-500 text-center">Henüz cevap yazılmamış.</p>
            @endif
        </div>
    </section>
</div>
@endsection
