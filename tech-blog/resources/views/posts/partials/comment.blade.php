<div class="border-2 border-black p-6 bg-white flex flex-col gap-2 {{ $comment->parent_id ? 'mt-4 border-r-8 border-r-gray-300 mr-8' : 'mb-6' }}">

    <div class="flex justify-between items-center border-b border-dashed border-black pb-2 mb-2">
        <a href="{{ route('author.show', $comment->user->username) }}" class="font-black hover:underline text-lg">
            {{ $comment->user->first_name }} {{ $comment->user->last_name }}
        </a>
        <span class="text-sm font-bold text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
    </div>

    <p class="text-lg font-medium">{{ $comment->content }}</p>

    <div class="flex items-center gap-6 mt-4">
        <form action="{{ route('likes.comment', $comment->id) }}" method="POST">
            @csrf
            <button type="submit" class="text-base font-bold flex items-center gap-2 hover:opacity-70 transition-opacity">
                @if(auth()->check() && auth()->user()->hasLiked($comment))
                    🖤 {{ $comment->likes->count() }}
                @else
                    🤍 {{ $comment->likes->count() }}
                @endif
            </button>
        </form>

        @auth
            <button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" class="text-base font-bold underline hover:text-gray-600">
                رد 💬
            </button>
        @endauth
    </div>

    @auth
        <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store', $post->id) }}" method="POST" class="hidden mt-6 flex flex-col gap-2 border-t-2 border-black pt-4">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="content" rows="2" class="w-full border-2 border-black p-3 text-base font-bold focus:ring-0 focus:outline-none focus:bg-gray-100 transition-colors" placeholder="اكتب ردك هنا..." required></textarea>
            <button type="submit" class="self-end border-2 border-black bg-black text-white px-6 py-2 font-bold hover:bg-white hover:text-black transition-all">
                إرسال الرد
            </button>
        </form>
    @endauth

    @if($comment->replies->count() > 0)
        <div class="mt-4">
            @foreach($comment->replies as $reply)
                @include('posts.partials.comment', ['comment' => $reply, 'post' => $post])
            @endforeach
        </div>
    @endif
</div>
