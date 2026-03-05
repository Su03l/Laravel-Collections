<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-4xl font-black uppercase tracking-tighter mb-1">تسجيل<br>الدخول</h2>
    <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mb-8" dir="ltr">// AUTHENTICATE</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-5">
            <label for="email" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="input-brutal" placeholder="EMAIL@EXAMPLE.COM" dir="ltr">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="password" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">كلمة المرور</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="input-brutal" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="border-4 border-black text-black focus:ring-0 rounded-none" name="remember">
                <span class="ms-2 font-mono text-xs text-gray-500">تذكرني</span>
            </label>

            @if (Route::has('password.request'))
            <a class="font-mono text-xs text-gray-400 hover:text-black transition-colors uppercase tracking-widest" href="{{ route('password.request') }}">
                نسيت؟
            </a>
            @endif
        </div>

        <button type="submit" class="btn-brutal w-full text-center py-4 mb-6">دخول</button>

        <p class="text-center font-mono text-xs text-gray-400 tracking-widest">
            ما عندك حساب؟
            <a href="{{ route('register') }}" class="text-black font-bold hover:bg-black hover:text-white px-2 transition-colors uppercase">سجّل</a>
        </p>
    </form>
</x-guest-layout>