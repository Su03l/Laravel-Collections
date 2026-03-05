<section>
    <header class="mb-8">
        <h2 class="text-2xl font-black uppercase tracking-tight">حذف الحساب</h2>
        <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mt-2" dir="ltr">// DANGER ZONE</p>
    </header>

    <p class="text-sm text-gray-500 mb-6 max-w-xl leading-relaxed">
        عند حذف حسابك، سيتم حذف جميع بياناتك بشكل نهائي. تأكد من تحميل أي بيانات ترغب في الاحتفاظ بها.
    </p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn-brutal text-xs py-3 px-8">حذف الحساب ✕</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black uppercase tracking-tight mb-2">تأكيد الحذف</h2>
            <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mb-6" dir="ltr">// THIS ACTION IS IRREVERSIBLE</p>

            <p class="text-sm text-gray-500 mb-6">أدخل كلمة المرور لتأكيد حذف حسابك نهائياً.</p>

            <div class="mb-6">
                <label for="password" class="sr-only">كلمة المرور</label>
                <input id="password" name="password" type="password" class="input-brutal w-full sm:w-3/4" placeholder="كلمة المرور">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-0">
                <x-secondary-button x-on:click="$dispatch('close')">إلغاء</x-secondary-button>
                <button type="submit" class="btn-brutal text-xs py-3 px-8">حذف نهائي</button>
            </div>
        </form>
    </x-modal>
</section>