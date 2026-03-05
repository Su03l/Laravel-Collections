@extends('layouts.blog')

@section('content')
    <div class="border-4 border-black p-10 bg-black text-white mb-16 flex flex-col md:flex-row gap-8 items-center md:items-start shadow-[12px_12px_0px_0px_rgba(200,200,200,1)]">
        <div class="w-32 h-32 rounded-full border-4 border-white overflow-hidden bg-gray-300 flex-shrink-0 flex items-center justify-center text-4xl font-black text-black">
            {{ Str::substr($author->first_name, 0, 1) }}
        </div>
        <div>
            <h1 class="text-5xl font-black mb-4">{{ $author->first_name }} {{ $author->last_name }}</h1>
            <p class="text-xl font-bold mb-2 text-gray-300">{{ '@' . $author->username }}</p>
            <p class="text-lg font-medium leading-relaxed">{{ $author->bio ?? 'كاتب تقني في هذه المدونة.' }}</p>
        </div>
    </div>

    <h2 class="text-4xl font-black mb-8 border-b-8 border-black inline-block pb-2">مقالات الكاتب ({{ $posts->total() }})</h2>

    <div class="space-y-8">
        @foreach($posts as $post)
            <article class="border-4 border-black p-6 hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-shadow duration-200 bg-white">
                <h3 class="text-2xl font-black mb-2">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
                </h3>
                <p class="text-sm font-bold mb-4">📅 {{ $post->created_at->format('Y/m/d') }}</p>
                <p class="text-base font-medium mb-4">{{ Str::limit($post->content, 150) }}</p>
                <a href="{{ route('posts.show', $post->slug) }}" class="font-bold border-b-2 border-black hover:bg-black hover:text-white transition-colors">اقرأ المزيد ➔</a>
            </article>
        @endforeach
    </div>

    <div class="mt-12 font-bold">
        {{ $posts->links() }}
    </div>
@endsection
