<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <h2 class="text-4xl font-black border-b-8 border-black inline-block pb-2 mb-10">تعديل المقال</h2>

        <form action="{{ route('user.posts.update', $post->id) }}" method="POST" class="border-4 border-black bg-white p-10 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] flex flex-col gap-8">
            @csrf
            @method('PUT') <div>
                <label class="block text-2xl font-black mb-2">عنوان المقال</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="w-full border-4 border-black p-4 text-xl font-bold focus:ring-0 focus:outline-none focus:bg-gray-50 transition-colors">
                @error('title') <span class="text-red-600 font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-2xl font-black mb-2">المحتوى</label>
                <textarea name="content" rows="10" required class="w-full border-4 border-black p-4 text-lg font-medium focus:ring-0 focus:outline-none focus:bg-gray-50 transition-colors">{{ old('content', $post->content) }}</textarea>
                @error('content') <span class="text-red-600 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold border-b-2 border-black hover:text-gray-600">إلغاء والعودة</a>
                <button type="submit" class="border-4 border-black bg-black text-white text-2xl font-black py-4 px-8 hover:bg-white hover:text-black transition-all">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
