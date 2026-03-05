@extends('layouts.blog')

@section('content')
<!-- Author Header -->
<div class="border-b-8 border-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="flex flex-col lg:flex-row gap-12 items-start">

            <!-- Avatar Block -->
            <div class="flex-shrink-0">
                @if($author->avatar)
                <img src="{{ asset('storage/' . $author->avatar) }}" alt="{{ $author->first_name }}"
                    class="w-40 h-40 object-cover border-4 border-black">
                @else
                <div class="w-40 h-40 bg-black text-white flex items-center justify-center text-7xl font-black border-4 border-black">
                    {{ Str::substr($author->first_name, 0, 1) }}
                </div>
                @endif
            </div>

            <!-- Author Info -->
            <div class="flex-1">
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-4" dir="ltr">// AUTHOR PROFILE</p>
                <h1 class="text-6xl lg:text-8xl font-black tracking-tighter uppercase leading-[0.85]">
                    {{ $author->first_name }}<br>{{ $author->last_name }}
                </h1>
                <p class="font-mono text-sm text-gray-400 mt-4" dir="ltr">{{ '@' . $author->username }}</p>
                @if($author->bio)
                <p class="text-lg text-gray-500 mt-6 max-w-2xl leading-relaxed">{{ $author->bio }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Author Details Grid -->
<div class="border-b-4 border-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-black" dir="ltr">

            <!-- Posts Count -->
            <div class="py-8 px-6 text-center">
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2">POSTS</p>
                <p class="text-4xl font-black">{{ $posts->total() }}</p>
            </div>

            <!-- Country -->
            <div class="py-8 px-6 text-center">
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2">COUNTRY</p>
                <p class="text-xl font-black">{{ $author->country ?? '—' }}</p>
            </div>

            <!-- Date of Birth -->
            <div class="py-8 px-6 text-center">
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2">BORN</p>
                <p class="text-xl font-black">{{ $author->date_of_birth ? $author->date_of_birth->format('Y') : '—' }}</p>
            </div>

            <!-- Member Since -->
            <div class="py-8 px-6 text-center">
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2">JOINED</p>
                <p class="text-xl font-black">{{ $author->created_at->format('Y.m') }}</p>
            </div>

        </div>
    </div>
</div>

<!-- Links Bar -->
@if($author->website_url || $author->github_url || $author->email)
<div class="border-b-4 border-black bg-black text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap gap-0">

            @if($author->website_url)
            <a href="{{ $author->website_url }}" target="_blank" rel="noopener"
                class="flex items-center gap-3 px-8 py-5 border-l border-gray-800 hover:bg-white hover:text-black transition-colors font-mono text-xs tracking-widest uppercase">
                <span>🌐</span>
                <span>WEBSITE</span>
            </a>
            @endif

            @if($author->github_url)
            <a href="{{ $author->github_url }}" target="_blank" rel="noopener"
                class="flex items-center gap-3 px-8 py-5 border-l border-gray-800 hover:bg-white hover:text-black transition-colors font-mono text-xs tracking-widest uppercase">
                <span>⌨</span>
                <span>GITHUB</span>
            </a>
            @endif

            <a href="mailto:{{ $author->email }}"
                class="flex items-center gap-3 px-8 py-5 border-l border-gray-800 hover:bg-white hover:text-black transition-colors font-mono text-xs tracking-widest uppercase">
                <span>✉</span>
                <span>EMAIL</span>
            </a>

        </div>
    </div>
</div>
@endif

<!-- Posts Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-12 border-b-4 border-black pb-6">
        <h2 class="text-3xl font-black uppercase tracking-tight">المقالات <span class="text-gray-300">({{ $posts->total() }})</span></h2>
        <span class="font-mono text-xs text-gray-400 tracking-widest uppercase" dir="ltr">// PUBLISHED WORK</span>
    </div>

    @if($posts->count() > 0)
    <div class="space-y-0">
        @foreach($posts as $index => $post)
        <article class="border-4 border-black {{ !$loop->first ? 'border-t-0' : '' }} p-8 flex flex-col lg:flex-row gap-6 lg:items-center hover:bg-gray-50 transition-colors group">
            <span class="text-5xl font-black text-gray-200 lg:w-24 flex-shrink-0">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <div class="flex-1">
                <h3 class="text-2xl font-black uppercase tracking-tight mb-2">
                    <a href="{{ route('posts.show', $post->slug) }}" class="group-hover:bg-black group-hover:text-white px-1 transition-colors">{{ $post->title }}</a>
                </h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ Str::limit($post->content, 150) }}</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-end gap-2">
                <span class="font-mono text-xs tracking-widest text-gray-400" dir="ltr">{{ $post->created_at->format('Y.m.d') }}</span>
                <span class="font-mono text-xs tracking-widest text-gray-400" dir="ltr">{{ $post->comments->count() }}C / {{ $post->likes->count() }}L</span>
            </div>
        </article>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $posts->links() }}
    </div>
    @else
    <div class="border-4 border-black text-center py-20 brutal-shadow">
        <p class="text-4xl font-black text-gray-200 uppercase mb-4">فارغ</p>
        <p class="font-mono text-xs text-gray-400 tracking-widest">لا توجد مقالات منشورة</p>
    </div>
    @endif
</div>
@endsection