<x-guest-layout>
    <h2 class="text-4xl font-black uppercase tracking-tighter mb-1">تأكيد<br>كلمة المرور</h2>
    <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mb-8" dir="ltr">// CONFIRM PASSWORD</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-6">
            <label for="password" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">كلمة المرور</label>
            <input id="password" type="password" name="password" required class="input-brutal" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <button type="submit" class="btn-brutal w-full text-center py-4">تأكيد</button>
    </form>
</x-guest-layout>