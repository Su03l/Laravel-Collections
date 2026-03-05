<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end">
            <div>
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2" dir="ltr">// MY DASHBOARD</p>
                <h2 class="text-4xl font-black tracking-tighter uppercase">لوحة التحكم</h2>
            </div>
            <div class="flex gap-0">
                <a href="{{ route('user.bookmarks') }}" class="btn-brutal-outline text-xs py-3 px-6">المحفوظات</a>
                <a href="{{ route('user.posts.create') }}" class="btn-brutal text-xs py-3 px-6">مقال جديد +</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if(session('success'))
        <div class="border-4 border-black bg-black text-white p-4 mb-8 font-mono text-sm tracking-wider">
            ✓ {{ session('success') }}
        </div>
        @endif

        <div class="border-4 border-black brutal-shadow bg-white">
            @if($posts->count() > 0)
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b-4 border-black bg-black text-white">
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest">#</th>
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest">العنوان</th>
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest" dir="ltr">DATE</th>
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest" dir="ltr">STATS</th>
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest text-center">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $index => $post)
                    <tr class="border-b-2 border-black hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-black text-2xl text-gray-200">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('posts.show', $post->slug) }}" class="font-bold hover:bg-black hover:text-white px-1 transition-colors">{{ $post->title }}</a>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-400" dir="ltr">{{ $post->created_at->format('Y.m.d') }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-400" dir="ltr">
                            {{ $post->comments->count() }}C / {{ $post->likes->count() }}L
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-0">
                                @if($post->created_at->diffInHours(now()) < 2)
                                    <a href="{{ route('user.posts.edit', $post->id) }}" class="border-4 border-black px-4 py-2 font-mono text-xs uppercase tracking-widest hover:bg-black hover:text-white transition-colors">تعديل</a>
                                    @endif
                                    <form action="{{ route('user.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('حذف نهائي؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-4 border-black border-r-0 px-4 py-2 font-mono text-xs uppercase tracking-widest hover:bg-black hover:text-white transition-colors">حذف</button>
                                    </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-6 border-t-2 border-black">
                {{ $posts->links() }}
            </div>
            @else
            <div class="text-center py-20">
                <p class="text-4xl font-black text-gray-200 uppercase mb-4">فارغ</p>
                <p class="font-mono text-xs text-gray-400 tracking-widest mb-6">لا توجد مقالات بعد</p>
                <a href="{{ route('user.posts.create') }}" class="btn-brutal text-xs py-3 px-8 inline-block">اكتب أول مقال</a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>