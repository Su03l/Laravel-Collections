<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-black">
    <div class="min-h-screen">
        <!-- Top Bar -->
        <div class="bg-black text-white font-mono text-xs tracking-widest uppercase py-2 text-center" dir="ltr">
            DASHBOARD — {{ auth()->user()->first_name ?? '' }} {{ auth()->user()->last_name ?? '' }}
        </div>

        <!-- Nav -->
        <nav class="border-b-8 border-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <a href="{{ route('home') }}" class="text-3xl font-black tracking-tighter uppercase">
                        المدونة<span class="bg-black text-white px-2 mr-1">_</span>
                    </a>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('home') }}" class="font-mono text-xs uppercase tracking-widest text-gray-500 hover:text-black px-4 py-2 border-4 border-transparent hover:border-black transition-all">المقالات</a>
                        <a href="{{ route('dashboard') }}" class="font-mono text-xs uppercase tracking-widest text-gray-500 hover:text-black px-4 py-2 border-4 border-transparent hover:border-black transition-all">لوحتي</a>
                        <a href="{{ route('profile.edit') }}" class="font-mono text-xs uppercase tracking-widest text-gray-500 hover:text-black px-4 py-2 border-4 border-transparent hover:border-black transition-all">ملفي</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-brutal text-xs py-2">خروج</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
        <header class="border-b-4 border-black">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>