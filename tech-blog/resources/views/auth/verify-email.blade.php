<x-guest-layout>
    <h2 class="text-4xl font-black uppercase tracking-tighter mb-1">تأكيد<br>البريد</h2>
    <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mb-8" dir="ltr">// VERIFY EMAIL</p>

    <p class="text-sm text-gray-500 mb-6 leading-relaxed">تم إرسال رابط التفعيل إلى بريدك الإلكتروني. اضغط عليه لتفعيل حسابك.</p>

    @if (session('status') == 'verification-link-sent')
    <div class="border-4 border-black bg-black text-white p-4 mb-6 font-mono text-xs tracking-wider">
        ✓ تم إرسال رابط تفعيل جديد.
    </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-brutal w-full text-center py-4">إعادة إرسال الرابط</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="font-mono text-xs text-gray-400 hover:text-black transition-colors uppercase tracking-widest w-full text-center py-3">تسجيل الخروج</button>
        </form>
    </div>
</x-guest-layout>