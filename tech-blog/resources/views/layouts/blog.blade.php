<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المدونة التقنية</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-white text-black antialiased selection:bg-black selection:text-white">

    <nav class="border-b-4 border-black p-5 flex justify-between items-center max-w-5xl mx-auto mt-4 mb-10">
        <a href="{{ route('home') }}" class="text-3xl font-black tracking-tighter hover:underline">المدونة.</a>
        <div class="font-bold">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="mr-6 border-b-4 border-black font-black text-lg hover:bg-black hover:text-white transition-colors px-2">👑 لوحة الإدارة</a>
                @endif

                <a href="{{ route('dashboard') }}" class="hover:underline font-bold text-lg">مقالاتي (لوحة التحكم)</a>

                <form method="POST" action="{{ route('logout') }}" class="inline ml-6">
                    @csrf
                    <button type="submit" class="border-2 border-black px-4 py-1 font-bold hover:bg-black hover:text-white transition-all text-sm">خروج</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline ml-6 text-lg font-bold">دخول</a>
                <a href="{{ route('register') }}" class="border-4 border-black px-5 py-2 font-black text-lg hover:bg-black hover:text-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:shadow-none transition-all duration-200">تسجيل حساب</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-5xl mx-auto p-4 mb-20">
        @yield('content')
    </main>

</body>
</html>
