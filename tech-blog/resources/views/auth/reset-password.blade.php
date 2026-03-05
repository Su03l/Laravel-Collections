<x-guest-layout>
    <h2 class="text-4xl font-black uppercase tracking-tighter mb-1">إعادة<br>تعيين</h2>
    <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mb-8" dir="ltr">// NEW PASSWORD</p>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-5">
            <label for="email" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">البريد</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required class="input-brutal" dir="ltr">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label for="password" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الجديدة</label>
                <input id="password" type="password" name="password" required class="input-brutal" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label for="password_confirmation" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">التأكيد</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="input-brutal" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <button type="submit" class="btn-brutal w-full text-center py-4">إعادة التعيين</button>
    </form>
</x-guest-layout>