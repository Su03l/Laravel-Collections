@extends('layouts.blog')

@section('content')
    <article class="border-4 border-black p-10 bg-white mb-16">
        <h1 class="text-5xl font-black mb-8 leading-tight">{{ $post->title }}</h1>

        <div class="flex flex-col md:flex-row justify-between md:items-center gap-6 border-b-4 border-black pb-6 mb-10">
            <div class="text-lg font-bold flex flex-wrap items-center gap-6">
                <a href="{{ route('author.show', $post->user->username) }}" class="hover:bg-black hover:text-white transition-colors px-2 py-1">
                    ✍️ الكاتب: {{ $post->user->first_name }} {{ $post->user->last_name }}
                </a>
                <span>📅 {{ $post->created_at->format('Y/m/d') }}</span>
            </div>

            @auth
                <div class="flex flex-wrap gap-4">
                    <form action="{{ route('likes.post', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="border-4 border-black px-6 py-2 font-black text-xl hover:bg-black hover:text-white transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                            {{ auth()->user()->hasLiked($post) ? '🖤' : '🤍' }} {{ $post->likes->count() }}
                        </button>
                    </form>

                    <form action="{{ route('bookmarks.toggle', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="border-4 border-black px-6 py-2 font-black text-xl hover:bg-black hover:text-white transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                            {{ auth()->user()->hasBookmarked($post) ? '🔖 تم الحفظ' : '📑 حفظ' }}
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        <div class="prose prose-lg max-w-none text-xl leading-loose font-medium mb-12">
            {{ $post->content }}
        </div>

        @if($post->attachments->count() > 0)
            <div class="mt-12 border-t-4 border-dashed border-black pt-8 mb-12">
                <h3 class="text-3xl font-black mb-8 border-b-2 border-black inline-block pb-2">المرفقات</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($post->attachments as $attachment)
                        @php
                            $ext = strtolower($attachment->file_type);
                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            $isVideo = in_array($ext, ['mp4', 'webm']);
                        @endphp

                        @if($isImage)
                            <div class="border-4 border-black p-2 bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}" class="w-full h-auto object-cover border-2 border-black hover:opacity-80 transition-opacity">
                                </a>
                            </div>
                        @elseif($isVideo)
                            <div class="border-4 border-black p-2 bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                                <video controls class="w-full h-auto border-2 border-black">
                                    <source src="{{ asset('storage/' . $attachment->file_path) }}" type="video/{{ $ext }}">
                                    متصفحك لا يدعم تشغيل الفيديو.
                                </video>
                            </div>
                        @else
                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="border-4 border-black p-6 bg-white flex justify-between items-center hover:bg-black hover:text-white transition-all shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-2 hover:translate-y-2 group">
                                <div class="overflow-hidden">
                                    <p class="font-black text-lg truncate w-full" dir="ltr">{{ $attachment->file_name }}</p>
                                    <p class="text-sm font-bold mt-1 text-gray-500 group-hover:text-gray-300">تحميل الملف ➔</p>
                                </div>
                                <span class="text-4xl font-black">📁</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <div class="flex flex-wrap gap-3 border-t-4 border-black pt-6">
            @foreach($post->tags as $tag)
                <span class="text-base border-2 border-black px-4 py-2 font-bold bg-gray-100">#{{ $tag->name }}</span>
            @endforeach
        </div>
    </article>

    <section class="border-4 border-black p-8 bg-gray-50">
        <h3 class="text-3xl font-black mb-8 border-b-2 border-black inline-block pb-2">التعليقات ({{ $post->comments->count() }})</h3>

        <div class="mb-12">
            @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <textarea name="content" rows="4" class="w-full border-4 border-black p-4 text-lg font-bold focus:ring-0 focus:outline-none focus:bg-gray-100 transition-colors" placeholder="اكتب تعليقك هنا..." required></textarea>
                    <button type="submit" class="self-end border-4 border-black bg-black text-white px-8 py-3 text-xl font-black hover:bg-white hover:text-black transition-all">
                        نشر التعليق
                    </button>
                </form>
            @else
                <div class="border-4 border-dashed border-black p-6 text-center">
                    <p class="text-xl font-bold mb-4">يجب عليك تسجيل الدخول لتتمكن من إضافة تعليق والمشاركة في النقاش.</p>
                    <a href="{{ route('login') }}" class="inline-block border-4 border-black bg-white px-6 py-2 font-black text-lg hover:bg-black hover:text-white transition-all">تسجيل الدخول</a>
                </div>
            @endauth
        </div>

        <div class="space-y-2">
            @forelse($post->rootComments as $comment)
                @include('posts.partials.comment', ['comment' => $comment, 'post' => $post])
            @empty
                <p class="text-xl font-bold text-center py-8 border-4 border-dashed border-black">لا توجد تعليقات حتى الآن. كُن أول من يشارك برأيه!</p>
            @endforelse
        </div>
    </section>
@endsection
