@foreach($comments as $comment)
    <div class="flex space-x-4 mb-6" x-data="{ replyOpen: false }">
        <div class="flex-shrink-0">
             <div class="w-10 h-10 bg-gray-300 dark:bg-gray-700 rounded-full flex items-center justify-center font-bold text-lg text-black dark:text-white">
                 {{ strtoupper(substr($comment->user->name, 0, 1)) }}
             </div>
        </div>
        <div class="flex-1">
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <div class="font-bold text-sm uppercase mb-1 text-black dark:text-white">{{ $comment->user->name }} <span class="text-gray-500 dark:text-gray-400 font-normal normal-case">&bull; {{ $comment->created_at->diffForHumans() }}</span></div>
                <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
            </div>
            
            <button @click="replyOpen = !replyOpen" class="text-xs font-bold uppercase mt-2 text-gray-500 hover:text-black dark:hover:text-white transition-colors">Yanıtla</button>

            <!-- Reply Form -->
            <div x-show="replyOpen" class="mt-4" style="display: none;">
                @auth
                    <form action="{{ route('questions.comment', $question) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="mb-2">
                            <textarea name="content" rows="2" class="w-full bg-white dark:bg-black border border-gray-300 dark:border-gray-700 p-3 focus:ring-2 focus:ring-black dark:focus:ring-white outline-none transition rounded-lg text-black dark:text-white" placeholder="Yanıtınızı yazın..." required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-black text-white dark:bg-white dark:text-black text-xs font-bold uppercase tracking-wider hover:opacity-80 transition rounded">Gönder</button>
                    </form>
                @else
                    <p class="text-sm text-gray-500">Yanıtlamak için <a href="{{ route('login') }}" class="underline">giriş yapın</a>.</p>
                @endauth
            </div>

            <!-- Recursive Children -->
            @if($comment->children->count() > 0)
                <div class="mt-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700">
                    @include('partials.question-replies', ['comments' => $comment->children, 'question' => $question])
                </div>
            @endif
        </div>
    </div>
@endforeach
