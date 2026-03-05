<x-app-layout>
    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center border-b-8 border-black pb-4 mb-8">
            <h2 class="text-4xl font-black">المقالات المحفوظة 🔖</h2>
            <a href="{{ route('dashboard') }}" class="border-4 border-black bg-white text-black px-6 py-2 text-xl font-black hover:bg-black hover:text-white transition-all">
                ➔ العودة لمقالاتي
            </a>
        </div>

        <div class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
            @if($bookmarks->count() > 0)
                <div class="space-y-6">
                    @foreach($bookmarks as $bookmark)
                        <div class="border-4 border-black p-6 flex flex-col md:flex-row justify-between md:items-center gap-4 hover:bg-gray-50 transition-colors">
                            <div>
                                <h3 class="text-2xl font-black mb-2">
                                    <a href="{{ route('posts.show', $bookmark->post->slug) }}" class="hover:underline" target="_blank">{{ $bookmark->post->title }}</a>
                                </h3>
                                <p class="text-lg font-bold text-gray-700">✍️ الكاتب: {{ $bookmark->post->user->first_name }} {{ $bookmark->post->user->last_name }}</p>
                            </div>

                            <div class="flex items-center gap-4">
                                <a href="{{ route('posts.show', $bookmark->post->slug) }}" class="border-b-4 border-black text-xl font-black hover:bg-black hover:text-white transition-all px-2 py-1">قراءة</a>

                                <form action="{{ route('bookmarks.toggle', $bookmark->post->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="border-4 border-black bg-black text-white px-4 py-2 font-bold hover:bg-white hover:text-black transition-colors" title="إزالة من المحفوظات">
                                        ❌ إزالة
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 font-bold">
                    {{ $bookmarks->links() }}
                </div>
            @else
                <div class="text-center py-12 border-4 border-dashed border-black">
                    <p class="text-2xl font-black mb-4">لم تقم بحفظ أي مقال حتى الآن.</p>
                    <a href="{{ route('home') }}" class="text-lg font-bold underline hover:text-gray-600">تصفح المقالات التقنية ➔</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
