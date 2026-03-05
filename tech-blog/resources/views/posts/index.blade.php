@extends('layouts.blog')

@section('content')
    <h1 class="text-4xl font-black mb-12 border-b-8 border-black inline-block pb-2">أحدث المقالات التقنية</h1>

    <div class="space-y-10">
        @foreach($posts as $post)
            <article class="border-4 border-black p-8 hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-shadow duration-200 bg-white">

                <h2 class="text-3xl font-black mb-4 leading-tight">
                    <a href="#" class="hover:underline">{{ $post->title }}</a>
                </h2>

                <div class="text-sm font-bold mb-6 flex flex-wrap items-center gap-6 border-b-2 border-dashed border-black pb-4">
                    <span>✍️ الكاتب: {{ $post->user->first_name }} {{ $post->user->last_name }}</span>
                    <span>📅 {{ $post->created_at->format('Y/m/d') }}</span>
                    <span>💬 {{ $post->comments->count() ?? rand(0, 15) }} تعليق</span>
                </div>

                <p class="text-lg leading-relaxed mb-8 font-medium">{{ Str::limit($post->content, 200) }}</p>

                <div class="flex justify-between items-center mt-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="text-sm border-2 border-black px-3 py-1 font-bold bg-gray-100">#{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <a href="#" class="font-bold border-b-2 border-black hover:bg-black hover:text-white transition-colors px-2 py-1 text-lg">
                        اقرأ المزيد ➔
                    </a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-16 font-bold">
        {{ $posts->links() }}
    </div>
@endsection
