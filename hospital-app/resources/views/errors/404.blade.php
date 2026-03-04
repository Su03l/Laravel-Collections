<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - الصفحة غير موجودة</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,700,800&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }

        /* Gradient Background */
        .hospital-gradient {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); /* Red gradient for error */
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
        }

        /* Glow Text */
        .glow-text {
            text-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
        }
    </style>
</head>
<body class="bg-[#0B1120] min-h-screen flex items-center justify-center p-4">
<div
    class="max-w-[800px] w-full bg-[#1E293B] rounded-[1.5rem] shadow-2xl overflow-hidden border border-slate-700 relative flex flex-col">

    <!-- macOS Style Title Bar -->
    <div class="bg-[#0F172A] px-6 py-4 flex items-center justify-between border-b border-slate-700 relative z-20">
        <div class="flex gap-2">
            <div class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600 transition-colors cursor-pointer"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-500 hover:bg-yellow-600 transition-colors cursor-pointer"></div>
            <div class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600 transition-colors cursor-pointer"></div>
        </div>
        <div class="text-slate-400 text-xs font-mono tracking-widest uppercase opacity-50 select-none">
            Error 404 — Not Found
        </div>
        <div class="w-10"></div> <!-- Spacer for centering -->
    </div>

    <div class="p-8 lg:p-16 text-center relative flex-1">
        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-full h-full bg-slate-900/50 pointer-events-none"></div>
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-red-500/10 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl opacity-30"></div>

        <div class="mb-6 relative z-10">
            <span
                class="px-4 py-1.5 bg-slate-800 text-red-400 text-sm font-bold rounded-full uppercase tracking-wider border border-slate-600">
                System Error
            </span>
        </div>

        <h1 class="text-6xl lg:text-8xl font-extrabold text-white mb-6 leading-tight relative z-10">
            <span class="text-red-500 glow-text">عذراً!</span> <br/>
            الصفحة مفقودة
        </h1>

        <p class="text-lg text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
            يبدو أنك ضللت الطريق في أروقة المستشفى الرقمي. <br>
            الرابط الذي تحاول الوصول إليه غير متاح أو تم نقله.
        </p>

        <div class="flex flex-wrap gap-4 justify-center relative z-10 mb-12">
            <a href="{{ url('/') }}"
               class="px-8 py-4 hospital-gradient text-white font-bold rounded-xl hover:opacity-90 transition-all active:scale-95 flex items-center gap-2 text-lg shadow-lg shadow-red-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                العودة للرئيسية
            </a>
        </div>

        <!-- Developer Hint -->
        <div
            class="mb-4 relative z-10 text-center bg-[#0F172A] p-4 rounded-xl border border-slate-700 hover:border-red-500/30 transition-colors inline-block mx-auto">
            <h3 class="text-sm font-bold text-slate-400 flex items-center gap-2 justify-center">
                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                هل تبحث عن الـ API؟
            </h3>
            <div class="mt-2">
                <code class="text-xs text-red-400 font-mono font-bold bg-black/40 px-2 py-1 rounded border border-slate-700"
                      dir="ltr">/api/v1/...</code>
            </div>
        </div>
    </div>
</div>
</body>
</html>
