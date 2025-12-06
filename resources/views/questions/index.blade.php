@extends('layouts.site')

@section('title', 'Kullanıcı Soruları - News Wrap')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black uppercase tracking-tighter">Soru & Cevap</h1>
        @auth
            <a href="{{ route('questions.create') }}" class="px-6 py-3 bg-black text-white dark:bg-white dark:text-black font-bold uppercase tracking-wider hover:opacity-80 transition rounded">Soru Sor</a>
        @endauth
    </div>

    <div class="overflow-hidden bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 sm:rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Konu</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Cevap</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-48">Son İşlem</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($questions as $question)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                     <div class="w-10 h-10 bg-black text-white dark:bg-white dark:text-black rounded-full flex items-center justify-center font-bold text-sm">
                                         {{ strtoupper(substr($question->user->name, 0, 1)) }}
                                     </div>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">
                                        <a href="{{ route('questions.show', $question) }}" class="hover:underline">
                                            {{ $question->title }}
                                        </a>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Gönderen: {{ $question->user->name }} &bull; {{ $question->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                {{ $question->comments->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                            @if($question->comments->isNotEmpty())
                                <div class="text-xs">
                                    Son: {{ $question->comments->last()->user->name }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $question->comments->last()->created_at->diffForHumans() }}
                                </div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                         <td colspan="3" class="px-6 py-12 text-center text-gray-500 font-bold">
                             Henüz soru sorulmamış. İlk soruyu sen sor!
                             <div class="mt-4">
                                @auth
                                    <a href="{{ route('questions.create') }}" class="inline-block px-6 py-2 bg-black text-white dark:bg-white dark:text-black font-bold uppercase tracking-wider hover:opacity-80 transition rounded">Soru Sor</a>
                                @endauth
                             </div>
                         </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $questions->links() }}
    </div>
</div>
@endsection
