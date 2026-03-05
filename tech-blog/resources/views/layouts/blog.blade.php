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
                <a href="{{ route('dashboard') }}" class="hover:underline">لوحة التحكم</a>
            @else
                <a href="{{ route('login') }}" class="hover:underline ml-6">دخول</a>
                <a href="{{ route('register') }}" class="border-2 border-black px-5 py-2 hover:bg-black hover:text-white transition-all">تسجيل حساب</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-5xl mx-auto p-4 mb-20">
        @yield('content')
    </main>

</body>
</html>
