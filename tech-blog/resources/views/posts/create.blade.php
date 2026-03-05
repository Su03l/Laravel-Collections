<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-4" dir="ltr">// CREATE NEW POST</p>
        <h2 class="text-4xl font-black tracking-tighter uppercase mb-12 border-b-4 border-black pb-6">كتابة مقال جديد</h2>

        <form action="{{ route('user.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-3">عنوان المقال</label>
                <input type="text" name="title" required class="input-brutal text-2xl font-black" placeholder="عنوان جذّاب ومميّز...">
                @error('title') <span class="font-mono text-xs text-gray-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-3">المحتوى</label>
                <textarea name="content" rows="12" required class="input-brutal resize-none" placeholder="اكتب محتوى مقالك هنا..."></textarea>
                @error('content') <span class="font-mono text-xs text-gray-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="border-4 border-dashed border-black p-8 text-center">
                <label class="block cursor-pointer">
                    <span class="font-mono text-xs uppercase tracking-widest">📎 إرفاق ملفات (صور، PDF، فيديو)</span>
                    <input type="file" name="attachments[]" multiple class="hidden" id="file-upload">
                </label>
                <p class="font-mono text-xs text-gray-400 mt-3" id="file-chosen">لم يتم اختيار أي ملف</p>
                @error('attachments.*') <span class="font-mono text-xs text-gray-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-brutal w-full text-center py-5 text-base">نشر المقال ←</button>
        </form>
    </div>

    <script>
        document.getElementById('file-upload').addEventListener('change', function() {
            document.getElementById('file-chosen').textContent = this.files.length + " ملفات تم اختيارها";
        });
    </script>
</x-app-layout>