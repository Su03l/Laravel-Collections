<x-guest-layout>
    <h2 class="text-4xl font-black uppercase tracking-tighter mb-1">حساب<br>جديد</h2>
    <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mb-8" dir="ltr">// CREATE ACCOUNT</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label for="first_name" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الاسم الأول</label>
                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                    class="input-brutal" placeholder="محمد">
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
            <div>
                <label for="last_name" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الاسم الأخير</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                    class="input-brutal" placeholder="العلي">
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <div class="mb-5">
            <label for="username" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">اسم المستخدم</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required
                class="input-brutal" placeholder="mohammed_ali" dir="ltr">
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="email" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="input-brutal" placeholder="EMAIL@EXAMPLE.COM" dir="ltr">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label for="password" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">كلمة المرور</label>
                <input id="password" type="password" name="password" required
                    class="input-brutal" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label for="password_confirmation" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">تأكيد</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="input-brutal" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <button type="submit" class="btn-brutal w-full text-center py-4 mb-6">إنشاء الحساب</button>

        <p class="text-center font-mono text-xs text-gray-400 tracking-widest">
            عندك حساب؟
            <a href="{{ route('login') }}" class="text-black font-bold hover:bg-black hover:text-white px-2 transition-colors uppercase">ادخل</a>
        </p>
    </form>
</x-guest-layout>