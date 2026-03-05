@extends('layouts.blog')

@section('content')
<!-- Article Header -->
<div class="border-b-4 border-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="flex flex-col gap-6">
            <div class="flex items-center gap-4 font-mono text-xs tracking-widest uppercase text-gray-400" dir="ltr">
                <span>{{ $post->created_at->format('Y.m.d // H:i') }}</span>
                <span class="text-gray-300">|</span>
                <span>{{ $post->comments->count() }} COMMENTS</span>
                <span class="text-gray-300">|</span>
                <span>{{ $post->likes->count() }} LIKES</span>
            </div>
            <h1 class="text-5xl lg:text-8xl font-black tracking-tighter leading-[0.85] uppercase">{{ $post->title }}</h1>
            <div class="flex items-center gap-6">
                <a href="{{ route('author.show', $post->user->username) }}" class="flex items-center gap-3 border-4 border-black px-4 py-2 hover:bg-black hover:text-white transition-colors">
                    <div class="w-10 h-10 bg-black text-white flex items-center justify-center font-black text-lg">{{ Str::substr($post->user->first_name, 0, 1) }}</div>
                    <div>
                        <p class="font-bold text-sm">{{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                        <p class="font-mono text-xs text-gray-400" dir="ltr">{{ '@' . $post->user->username }}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Article Content -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="prose prose-xl max-w-none text-lg leading-relaxed whitespace-pre-line">
        {{ $post->content }}
    </div>

    <!-- Attachments -->
    @if($post->attachments->count() > 0)
    <div class="mt-16 border-4 border-black p-8">
        <h3 class="font-black text-xl uppercase mb-6 border-b-4 border-black pb-4">المرفقات</h3>
        <div class="space-y-4">
            @foreach($post->attachments as $attachment)
            @if(Str::startsWith($attachment->mime_type, 'image'))
            <img src="{{ asset('storage/' . $attachment->path) }}" alt="مرفق" class="border-4 border-black w-full">
            @elseif(Str::startsWith($attachment->mime_type, 'video'))
            <video controls class="border-4 border-black w-full">
                <source src="{{ asset('storage/' . $attachment->path) }}" type="{{ $attachment->mime_type }}">
            </video>
            @else
            <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" class="btn-brutal-outline text-xs py-2 px-6 inline-block">
                📎 {{ $attachment->original_name }}
            </a>
            @endif
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Actions Bar -->
<div class="border-t-4 border-b-4 border-black">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-6">
            @auth
            <div class="flex gap-0">
                <!-- Like -->
                <form action="{{ route('likes.post', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="{{ auth()->user()->hasLiked($post) ? 'bg-black text-white' : 'bg-white text-black' }} border-4 border-black px-8 py-3 font-bold text-sm uppercase tracking-widest hover:bg-black hover:text-white transition-colors">
                        ♥ {{ $post->likes->count() }}
                    </button>
                </form>

                <!-- Bookmark -->
                <form action="{{ route('bookmarks.toggle', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="{{ auth()->user()->hasBookmarked($post) ? 'bg-black text-white' : 'bg-white text-black' }} border-4 border-black border-r-0 px-8 py-3 font-bold text-sm uppercase tracking-widest hover:bg-black hover:text-white transition-colors">
                        ★ حفظ
                    </button>
                </form>
            </div>
            @else
            <div class="font-mono text-xs text-gray-400 tracking-widest uppercase">سجّل دخولك للتفاعل</div>
            @endauth
            <span class="font-mono text-xs text-gray-400 tracking-widest" dir="ltr">POST #{{ $post->id }}</span>
        </div>
    </div>
</div>

<!-- Comments Section -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-12 border-b-4 border-black pb-6">
        <h2 class="text-3xl font-black uppercase tracking-tight">التعليقات <span class="text-gray-300">({{ $post->comments->where('parent_id', null)->count() }})</span></h2>
        <span class="font-mono text-xs text-gray-400 tracking-widest uppercase" dir="ltr">// DISCUSSION</span>
    </div>

    <!-- Add Comment -->
    @auth
    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-12 border-4 border-black p-6 brutal-shadow-sm">
        @csrf
        <textarea name="content" rows="4" required class="input-brutal mb-4 resize-none" placeholder="اكتب تعليقك هنا..."></textarea>
        <button type="submit" class="btn-brutal text-xs py-3 px-8">أرسل التعليق</button>
    </form>
    @endauth

    <!-- Comments List -->
    <div class="space-y-6">
        @foreach($post->comments->where('parent_id', null) as $comment)
        @include('posts.partials.comment', ['comment' => $comment])
        @endforeach
    </div>
</div>
@endsection