<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="flex justify-between items-end border-b-4 border-black pb-6 mb-12">
            <div>
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2" dir="ltr">// SAVED ITEMS</p>
                <h2 class="text-4xl font-black tracking-tighter uppercase">المحفوظات</h2>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-brutal-outline text-xs py-3 px-6">← العودة</a>
        </div>

        @if($bookmarks->count() > 0)
        <div class="space-y-0">
            @foreach($bookmarks as $index => $bookmark)
            <div class="border-4 border-black {{ !$loop->first ? 'border-t-0' : '' }} p-6 flex flex-col lg:flex-row justify-between lg:items-center gap-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-start gap-4">
                    <span class="text-3xl font-black text-gray-200 w-10 flex-shrink-0">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight mb-1">
                            <a href="{{ route('posts.show', $bookmark->post->slug) }}" class="hover:bg-black hover:text-white px-1 transition-colors" target="_blank">{{ $bookmark->post->title }}</a>
                        </h3>
                        <p class="font-mono text-xs text-gray-400 tracking-widest">{{ $bookmark->post->user->first_name }} {{ $bookmark->post->user->last_name }}</p>
                    </div>
                </div>
                <form action="{{ route('bookmarks.toggle', $bookmark->post->id) }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="btn-brutal text-xs py-2 px-6">إزالة ✕</button>
                </form>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $bookmarks->links() }}
        </div>
        @else
        <div class="border-4 border-black text-center py-20 brutal-shadow">
            <p class="text-4xl font-black text-gray-200 uppercase mb-4">فارغ</p>
            <p class="font-mono text-xs text-gray-400 tracking-widest mb-6">لم تقم بحفظ أي مقال</p>
            <a href="{{ route('home') }}" class="btn-brutal text-xs py-3 px-8 inline-block">تصفح المقالات</a>
        </div>
        @endif
    </div>
</x-app-layout>