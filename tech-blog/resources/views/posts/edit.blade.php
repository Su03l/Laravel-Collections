<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-4" dir="ltr">// EDIT POST #{{ $post->id }}</p>
        <h2 class="text-4xl font-black tracking-tighter uppercase mb-12 border-b-4 border-black pb-6">تعديل المقال</h2>

        <form action="{{ route('user.posts.update', $post->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-3">عنوان المقال</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="input-brutal text-2xl font-black">
                @error('title') <span class="font-mono text-xs text-gray-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-3">المحتوى</label>
                <textarea name="content" rows="12" required class="input-brutal resize-none">{{ old('content', $post->content) }}</textarea>
                @error('content') <span class="font-mono text-xs text-gray-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-0">
                <a href="{{ route('dashboard') }}" class="btn-brutal-outline text-center py-5 px-8 text-xs">إلغاء</a>
                <button type="submit" class="btn-brutal flex-1 text-center py-5 text-base">حفظ التعديلات ←</button>
            </div>
        </form>
    </div>
</x-app-layout>