<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <h2 class="text-4xl font-black border-b-8 border-black inline-block pb-2 mb-10">كتابة مقال جديد</h2>

        <form action="{{ route('user.posts.store') }}" method="POST" enctype="multipart/form-data" class="border-4 border-black bg-white p-10 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] flex flex-col gap-8">
            @csrf

            <div>
                <label class="block text-2xl font-black mb-2">عنوان المقال</label>
                <input type="text" name="title" required class="w-full border-4 border-black p-4 text-xl font-bold focus:ring-0 focus:outline-none focus:bg-gray-50 transition-colors" placeholder="اكتب عنواناً جذاباً...">
                @error('title') <span class="text-red-600 font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-2xl font-black mb-2">المحتوى</label>
                <textarea name="content" rows="10" required class="w-full border-4 border-black p-4 text-lg font-medium focus:ring-0 focus:outline-none focus:bg-gray-50 transition-colors" placeholder="اكتب محتوى مقالك هنا..."></textarea>
                @error('content') <span class="text-red-600 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="border-4 border-dashed border-black p-6 bg-gray-50 text-center">
                <label class="block text-xl font-black mb-4 cursor-pointer">
                    📎 أضف مرفقات (صور، PDF، فيديو)
                    <input type="file" name="attachments[]" multiple class="hidden" id="file-upload">
                </label>
                <p class="text-sm font-bold text-gray-500" id="file-chosen">لم يتم اختيار أي ملف</p>
                @error('attachments.*') <span class="text-red-600 font-bold">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="border-4 border-black bg-black text-white text-2xl font-black py-4 hover:bg-white hover:text-black transition-all">
                نشر المقال الآن
            </button>
        </form>
    </div>

    <script>
        document.getElementById('file-upload').addEventListener('change', function(){
            document.getElementById('file-chosen').textContent = this.files.length + " ملفات تم اختيارها";
        });
    </script>
</x-app-layout>
