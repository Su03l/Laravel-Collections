<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'المدونة التقنية') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;600;700&family=IBM+Plex+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }

        .font-mono {
            font-family: 'IBM Plex Mono', monospace;
        }
    </style>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-white text-black antialiased">

    <!-- Top Marquee -->
    <div class="bg-black text-white overflow-hidden">
        <div class="py-2 whitespace-nowrap marquee inline-block">
            <span class="font-mono text-xs tracking-widest uppercase px-8">تطوير ويب</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">ذكاء اصطناعي</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">مجتمع المطورين العرب</span>
            <span class="text-gray-600">///</span>
            <span class="font-mono text-xs tracking-widest uppercase px-8">Laravel × React</span>
            <span class="text-gray-600">///</span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="border-b-8 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                <a href="/" class="text-4xl font-black tracking-tighter uppercase">
                    المدونة<span class="bg-black text-white px-2 mr-1">_</span>
                </a>
                <div class="flex items-center gap-2">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="btn-brutal text-xs py-3">لوحة التحكم</a>
                    @else
                    <a href="{{ route('login') }}" class="font-mono text-xs uppercase tracking-widest text-gray-500 hover:text-black px-4 py-2 border-4 border-transparent hover:border-black transition-all">دخول</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-brutal text-xs py-3">حساب جديد</a>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="border-b-4 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-24 lg:py-40">
                <div class="flex flex-col gap-6">
                    <p class="font-mono text-xs tracking-widest uppercase text-gray-500">// EST. {{ date('Y') }} — DEVELOPER COMMUNITY</p>
                    <h1 class="text-7xl lg:text-[10rem] font-black leading-[0.85] tracking-tighter uppercase">
                        مدونة<br>
                        <span class="text-white bg-black px-4 inline-block mt-2">تقنية</span>
                    </h1>
                    <p class="text-xl text-gray-500 max-w-lg mt-4 leading-relaxed">
                        منصة مفتوحة للمطورين العرب. اكتب، شارك، وابنِ سمعتك التقنية.
                    </p>
                    <div class="flex gap-0 mt-4">
                        <a href="{{ route('home') }}" class="btn-brutal text-base py-5 px-12">تصفّح المقالات</a>
                        @guest
                        <a href="{{ route('register') }}" class="btn-brutal-outline text-base py-5 px-12">انضم الآن</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="border-b-4 border-black bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 divide-x divide-gray-800" dir="ltr">
                <div class="py-6 text-center">
                    <p class="font-mono text-xs tracking-widest uppercase text-gray-500">PLATFORM</p>
                    <p class="text-2xl font-black mt-1">LARAVEL</p>
                </div>
                <div class="py-6 text-center">
                    <p class="font-mono text-xs tracking-widest uppercase text-gray-500">DESIGN</p>
                    <p class="text-2xl font-black mt-1">BRUTALIST</p>
                </div>
                <div class="py-6 text-center">
                    <p class="font-mono text-xs tracking-widest uppercase text-gray-500">LANGUAGE</p>
                    <p class="text-2xl font-black mt-1">العربية</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t-8 border-black mt-20 py-16 text-center">
        <span class="font-mono text-xs text-gray-400 tracking-widest uppercase">&copy; {{ date('Y') }} المدونة التقنية — جميع الحقوق محفوظة</span>
    </footer>
</body>

</html>