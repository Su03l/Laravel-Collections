<section>
    <header class="mb-8">
        <h2 class="text-2xl font-black uppercase tracking-tight">تغيير كلمة المرور</h2>
        <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mt-2" dir="ltr">// UPDATE PASSWORD</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">كلمة المرور الحالية</label>
            <input id="update_password_current_password" name="current_password" type="password" class="input-brutal" placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="update_password_password" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الجديدة</label>
                <input id="update_password_password" name="password" type="password" class="input-brutal" placeholder="••••••••">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
            <div>
                <label for="update_password_password_confirmation" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">التأكيد</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="input-brutal" placeholder="••••••••">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-brutal text-xs py-3 px-8">تحديث</button>
            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="font-mono text-xs text-gray-500">✓ تم التحديث</p>
            @endif
        </div>
    </form>
</section>