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

<body class="font-sans text-black antialiased bg-white">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
        <!-- Logo -->
        <div class="mb-8">
            <a href="/" class="text-4xl font-black tracking-tighter uppercase">
                المدونة<span class="bg-black text-white px-2 mr-1">_</span>
            </a>
        </div>

        <!-- Card -->
        <div class="w-full sm:max-w-lg border-4 border-black p-8 lg:p-10 brutal-shadow bg-white">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="font-mono text-xs text-gray-400 tracking-widest uppercase mt-8" dir="ltr">// SECURE ACCESS POINT</p>
    </div>
</body>

</html>