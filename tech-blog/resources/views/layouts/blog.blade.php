<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المدونة التقنية</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;600;700&family=IBM+Plex+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }

        .font-mono {
            font-family: 'IBM Plex Mono', monospace;
        }
    </style>
</head>

<body class="bg-white text-black antialiased">

    <!-- Top Marquee Bar -->
    <div class="bg-black text-white overflow-hidden border-b-4 border-black">
        <div class="py-2 whitespace-nowrap marquee inline-block">
            <span class="font-mono text-xs tracking-widest uppercase px-8">تطوير ويب</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">ذكاء اصطناعي</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">أمن سيبراني</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">DevOps</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">قواعد بيانات</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">تطبيقات موبايل</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">Laravel</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">React</span>
            <span class="text-gray-600">///</span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="border-b-8 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-4xl font-black tracking-tighter text-black uppercase">
                        المدونة<span class="text-white bg-black px-2 mr-1">_</span>
                    </a>
                </div>

                <div class="flex items-center gap-1">
                    @auth
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="font-mono text-xs uppercase tracking-widest text-gray-500 hover:text-black transition-colors px-4 py-2 border-4 border-transparent hover:border-black">إدارة</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="font-mono text-xs uppercase tracking-widest text-gray-500 hover:text-black transition-colors px-4 py-2 border-4 border-transparent hover:border-black">لوحتي</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-brutal text-xs py-3">خروج</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="font-mono text-xs uppercase tracking-widest text-gray-500 hover:text-black transition-colors px-4 py-2 border-4 border-transparent hover:border-black">دخول</a>
                    <a href="{{ route('register') }}" class="btn-brutal text-xs py-3">حساب جديد</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t-8 border-black mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                <div>
                    <span class="text-6xl font-black tracking-tighter">المدونة<span class="bg-black text-white px-2 mr-1">_</span></span>
                    <p class="font-mono text-xs text-gray-500 mt-4 tracking-wider uppercase">مجتمع المطورين العرب — {{ date('Y') }}</p>
                </div>
                <div class="font-mono text-xs text-gray-400 tracking-wider text-left" dir="ltr">
                    <p>BUILT WITH LARAVEL</p>
                    <p>DESIGNED WITH BRUTALISM</p>
                    <p>© {{ date('Y') }} ALL RIGHTS RESERVED</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>