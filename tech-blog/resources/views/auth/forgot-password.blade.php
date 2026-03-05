<x-guest-layout>
    <h2 class="text-4xl font-black uppercase tracking-tighter mb-1">استعادة<br>كلمة المرور</h2>
    <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mb-8" dir="ltr">// RESET PASSWORD</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-6">
            <label for="email" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="input-brutal" placeholder="EMAIL@EXAMPLE.COM" dir="ltr">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <button type="submit" class="btn-brutal w-full text-center py-4 mb-6">إرسال رابط الاستعادة</button>
        <p class="text-center font-mono text-xs text-gray-400 tracking-widest">
            <a href="{{ route('login') }}" class="text-black font-bold hover:bg-black hover:text-white px-2 transition-colors uppercase">← الرجوع</a>
        </p>
    </form>
</x-guest-layout>