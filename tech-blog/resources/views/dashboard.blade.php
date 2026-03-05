<x-app-layout>
    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="border-4 border-black bg-white p-4 mb-8 font-bold text-xl">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="border-4 border-black bg-black text-white p-4 mb-8 font-bold text-xl">
                ❌ {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center border-b-8 border-black pb-4 mb-8 gap-4">
            <div class="flex items-center gap-6">
                <h2 class="text-4xl font-black">مقالاتي</h2>
                <a href="{{ route('user.bookmarks') }}" class="text-xl font-bold border-b-4 border-black hover:bg-black hover:text-white transition-colors px-2 py-1">المحفوظات 🔖</a>
            </div>

            <a href="{{ route('user.posts.create') }}" class="border-4 border-black bg-black text-white px-6 py-2 text-xl font-black hover:bg-white hover:text-black transition-all">
                + كتابة مقال جديد
            </a>
        </div>

        <div class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
            @if($posts->count() > 0)
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="border-b-4 border-black text-xl">
                            <th class="py-4 font-black w-2/5">العنوان</th>
                            <th class="py-4 font-black">التاريخ</th>
                            <th class="py-4 font-black text-center w-1/3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr class="border-b-2 border-dashed border-black hover:bg-gray-50 transition-colors">
                                <td class="py-4 font-bold text-lg"><a href="{{ route('posts.show', $post->slug) }}" class="hover:underline" target="_blank">{{ $post->title }}</a></td>
                                <td class="py-4 font-medium">{{ $post->created_at->format('Y/m/d h:i A') }}</td>
                                <td class="py-4 text-center flex justify-center gap-2 items-center h-full mt-2">

                                    @if($post->created_at->diffInHours(now()) < 2)
                                        <a href="{{ route('user.posts.edit', $post->id) }}" class="border-2 border-black bg-white text-black px-4 py-1 font-bold hover:bg-black hover:text-white transition-colors">تعديل</a>
                                    @else
                                        <span class="border-2 border-gray-300 text-gray-400 px-4 py-1 font-bold cursor-not-allowed" title="انتهى وقت التعديل المسموح">مغلق</span>
                                    @endif

                                    <form action="{{ route('user.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف المقال نهائياً؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-2 border-black bg-black text-white px-4 py-1 font-bold hover:bg-white hover:text-black transition-colors">حذف</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-8 font-bold">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-2xl font-bold mb-4">لم تكتب أي مقال حتى الآن.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
