<section>
    <header class="mb-8">
        <h2 class="text-2xl font-black uppercase tracking-tight">معلومات الملف الشخصي</h2>
        <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mt-2" dir="ltr">// PROFILE INFO</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <!-- الأسماء -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الاسم الأول</label>
                <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required class="input-brutal">
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
            <div>
                <label for="last_name" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الاسم الأخير</label>
                <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" required class="input-brutal">
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <!-- اسم المستخدم -->
        <div>
            <label for="username" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">اسم المستخدم</label>
            <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required class="input-brutal" dir="ltr" placeholder="username">
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- البريد -->
        <div>
            <label for="email" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="input-brutal" dir="ltr">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-3">
                <p class="font-mono text-xs text-gray-500">
                    بريدك غير مُفعّل.
                    <button form="send-verification" class="underline hover:text-black transition-colors">إعادة إرسال رابط التفعيل.</button>
                </p>
                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-mono text-xs text-black font-bold">✓ تم إرسال رابط تفعيل جديد.</p>
                @endif
            </div>
            @endif
        </div>

        <!-- النبذة -->
        <div>
            <label for="bio" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">النبذة الشخصية</label>
            <textarea id="bio" name="bio" rows="4" class="input-brutal resize-none" placeholder="اكتب نبذة مختصرة عنك...">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- تاريخ الميلاد والدولة -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="date_of_birth" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">تاريخ الميلاد</label>
                <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" class="input-brutal" dir="ltr">
                <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
            </div>
            <div>
                <label for="country" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الدولة</label>
                <input id="country" name="country" type="text" value="{{ old('country', $user->country) }}" class="input-brutal" placeholder="السعودية">
                <x-input-error class="mt-2" :messages="$errors->get('country')" />
            </div>
        </div>

        <!-- الروابط -->
        <div class="border-4 border-black p-6">
            <p class="font-mono text-xs uppercase tracking-widest text-gray-400 mb-4" dir="ltr">// SOCIAL LINKS</p>
            <div class="space-y-4">
                <div>
                    <label for="website_url" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">🌐 الموقع الشخصي</label>
                    <input id="website_url" name="website_url" type="url" value="{{ old('website_url', $user->website_url) }}" class="input-brutal" dir="ltr" placeholder="https://example.com">
                    <x-input-error class="mt-2" :messages="$errors->get('website_url')" />
                </div>
                <div>
                    <label for="github_url" class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">⌨ حساب GitHub</label>
                    <input id="github_url" name="github_url" type="url" value="{{ old('github_url', $user->github_url) }}" class="input-brutal" dir="ltr" placeholder="https://github.com/username">
                    <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
                </div>
            </div>
        </div>

        <!-- الصور -->
        <div class="border-4 border-black p-6">
            <p class="font-mono text-xs uppercase tracking-widest text-gray-400 mb-4" dir="ltr">// IMAGES</p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">الصورة الشخصية</label>
                    @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" class="w-20 h-20 object-cover border-4 border-black mb-3">
                    @else
                    <div class="w-20 h-20 bg-black text-white flex items-center justify-center text-2xl font-black border-4 border-black mb-3">
                        {{ Str::substr($user->first_name, 0, 1) }}
                    </div>
                    @endif
                    <input type="file" name="avatar" accept="image/*" class="font-mono text-xs">
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>
                <div>
                    <label class="block font-mono text-xs uppercase tracking-widest text-gray-500 mb-2">صورة الغلاف</label>
                    @if($user->header_image)
                    <img src="{{ asset('storage/' . $user->header_image) }}" alt="header" class="w-full h-20 object-cover border-4 border-black mb-3">
                    @else
                    <div class="w-full h-20 bg-gray-100 border-4 border-dashed border-black flex items-center justify-center mb-3">
                        <span class="font-mono text-xs text-gray-400">لا يوجد غلاف</span>
                    </div>
                    @endif
                    <input type="file" name="header_image" accept="image/*" class="font-mono text-xs">
                    <x-input-error class="mt-2" :messages="$errors->get('header_image')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-brutal text-xs py-3 px-8">حفظ التغييرات</button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="font-mono text-xs text-gray-500">✓ تم الحفظ</p>
            @endif
        </div>
    </form>
</section>