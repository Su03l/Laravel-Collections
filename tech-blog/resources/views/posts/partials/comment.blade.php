<div class="border-4 border-black p-6 mb-4 {{ $comment->parent_id ? 'mr-8 lg:mr-16 border-r-8' : '' }}">
    <div class="flex justify-between items-start mb-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-black text-white flex items-center justify-center font-bold text-xs">
                {{ Str::substr($comment->user->first_name, 0, 1) }}
            </div>
            <div>
                <span class="font-bold text-sm">{{ $comment->user->first_name }}</span>
                <span class="font-mono text-xs text-gray-400 mr-3" dir="ltr">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @auth
        <form action="{{ route('likes.comment', $comment->id) }}" method="POST">
            @csrf
            <button type="submit" class="font-mono text-xs border-2 border-black px-3 py-1 {{ auth()->user()->hasLiked($comment) ? 'bg-black text-white' : 'hover:bg-black hover:text-white' }} transition-colors">
                ♥ {{ $comment->likes->count() }}
            </button>
        </form>
        @endauth
    </div>

    <p class="text-sm leading-relaxed mb-4">{{ $comment->content }}</p>

    @auth
    @if(!$comment->parent_id)
    <div x-data="{ replying: false }">
        <button @click="replying = !replying" class="font-mono text-xs uppercase tracking-widest text-gray-400 hover:text-black transition-colors">← ردّ</button>
        <form x-show="replying" x-cloak action="{{ route('comments.store', $comment->post->id) }}" method="POST" class="mt-4 flex gap-2">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <input type="text" name="content" required class="input-brutal flex-1" placeholder="اكتب ردك...">
            <button type="submit" class="btn-brutal text-xs py-3 px-6">ردّ</button>
        </form>
    </div>
    @endif
    @endauth

    @if($comment->replies && $comment->replies->count() > 0)
    <div class="mt-4 space-y-4">
        @foreach($comment->replies as $reply)
        @include('posts.partials.comment', ['comment' => $reply])
        @endforeach
    </div>
    @endif
</div>