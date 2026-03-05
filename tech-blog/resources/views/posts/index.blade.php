@extends('layouts.blog')

@section('content')
<!-- Section Header -->
<div class="border-b-4 border-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-end">
            <div>
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-4">// ALL POSTS — {{ $posts->total() ?? '' }} ENTRIES</p>
                <h1 class="text-6xl lg:text-8xl font-black tracking-tighter uppercase leading-[0.85]">أحدث<br>المقالات</h1>
            </div>
            <div class="hidden lg:block">
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 text-left" dir="ltr">SORTED BY<br>LATEST FIRST<br>—————</p>
            </div>
        </div>
    </div>
</div>

<!-- Articles Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    @foreach($posts as $index => $post)
    @if($index === 0)
    <!-- Featured First Article - Full Width -->
    <article class="border-4 border-black p-8 lg:p-12 brutal-shadow mb-12 hover:translate-x-1 hover:-translate-y-1 transition-transform duration-200 bg-white">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-6">
                    <span class="font-mono text-xs tracking-widest uppercase text-gray-400" dir="ltr">{{ $post->created_at->format('Y.m.d') }}</span>
                    <span class="text-gray-300">|</span>
                    <span class="font-mono text-xs tracking-widest uppercase text-gray-400">{{ $post->user->first_name }} {{ $post->user->last_name }}</span>
                </div>
                <h2 class="text-4xl lg:text-6xl font-black tracking-tight leading-[0.9] mb-6 uppercase">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:bg-black hover:text-white transition-colors px-1">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-gray-500 text-lg leading-relaxed mb-8 max-w-2xl">{{ Str::limit($post->content, 200) }}</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('posts.show', $post->slug) }}" class="btn-brutal text-xs py-3 px-8">اقرأ المقال</a>
                    <div class="font-mono text-xs text-gray-400 tracking-widest" dir="ltr">
                        {{ $post->comments->count() }} COMMENTS / {{ $post->likes->count() }} LIKES
                    </div>
                </div>
            </div>
            <div class="lg:w-72 flex-shrink-0 border-4 border-black bg-black text-white p-8 flex flex-col justify-center items-center">
                <span class="text-8xl font-black">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="font-mono text-xs tracking-widest uppercase mt-2">FEATURED</span>
            </div>
        </div>
    </article>
    @else
    @if($index === 1)
    <!-- Asymmetric Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
        @endif

        @if($index % 3 === 1)
        <!-- Large Card -->
        <article class="lg:col-span-7 border-4 border-black p-8 brutal-shadow-sm hover:translate-x-1 hover:-translate-y-1 transition-transform duration-200 bg-white">
            <div class="flex items-center gap-4 mb-4">
                <span class="bg-black text-white font-mono text-xs px-3 py-1 tracking-widest">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="font-mono text-xs tracking-widest uppercase text-gray-400" dir="ltr">{{ $post->created_at->format('Y.m.d') }}</span>
            </div>
            <h2 class="text-3xl font-black tracking-tight leading-tight mb-4 uppercase">
                <a href="{{ route('posts.show', $post->slug) }}" class="hover:bg-black hover:text-white transition-colors px-1">{{ $post->title }}</a>
            </h2>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">{{ Str::limit($post->content, 120) }}</p>
            <div class="flex justify-between items-center border-t-2 border-black pt-4">
                <span class="font-mono text-xs text-gray-400">{{ $post->user->first_name }}</span>
                <div class="flex gap-2">
                    @foreach($post->tags->take(2) as $tag)
                    <span class="font-mono text-xs border-2 border-black px-2 py-1 uppercase">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        </article>
        @elseif($index % 3 === 2)
        <!-- Small Card -->
        <article class="lg:col-span-5 border-4 border-black border-r-0 lg:border-r-4 p-8 bg-black text-white hover:bg-white hover:text-black transition-colors duration-200">
            <div class="flex items-center gap-4 mb-4">
                <span class="bg-white text-black font-mono text-xs px-3 py-1 tracking-widest">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="font-mono text-xs tracking-widest uppercase opacity-50" dir="ltr">{{ $post->created_at->format('Y.m.d') }}</span>
            </div>
            <h2 class="text-2xl font-black tracking-tight leading-tight mb-4 uppercase">
                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
            </h2>
            <p class="opacity-60 text-sm leading-relaxed mb-6">{{ Str::limit($post->content, 80) }}</p>
            <span class="font-mono text-xs opacity-50">{{ $post->user->first_name }} {{ $post->user->last_name }}</span>
        </article>
        @else
        <!-- Wide Card -->
        <article class="lg:col-span-12 border-4 border-black p-6 brutal-shadow-sm hover:translate-x-1 hover:-translate-y-1 transition-transform duration-200 bg-white flex flex-col lg:flex-row lg:items-center gap-6">
            <span class="text-5xl font-black text-gray-200 lg:w-24 flex-shrink-0">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <div class="flex-1">
                <h2 class="text-2xl font-black tracking-tight leading-tight uppercase">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:bg-black hover:text-white transition-colors px-1">{{ $post->title }}</a>
                </h2>
            </div>
            <div class="flex items-center gap-6 flex-shrink-0">
                <span class="font-mono text-xs tracking-widest text-gray-400" dir="ltr">{{ $post->created_at->format('Y.m.d') }}</span>
                <span class="font-mono text-xs text-gray-400">{{ $post->user->first_name }}</span>
                <a href="{{ route('posts.show', $post->slug) }}" class="btn-brutal text-xs py-2 px-6">اقرأ</a>
            </div>
        </article>
        @endif

        @if($loop->last)
    </div>
    @endif
    @endif
    @endforeach
</div>

<!-- Pagination -->
<div class="border-t-4 border-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection