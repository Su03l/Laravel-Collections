<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital App - نظام حجز المواعيد الطبي</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,700,800&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }

        .hospital-gradient {
            background: linear-gradient(135deg, #0EA5E9 0%, #3b82f6 100%);
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.4);
        }

        .glow-text {
            text-shadow: 0 0 20px rgba(14, 165, 233, 0.5);
        }
    </style>
</head>
<body class="bg-[#0B1120] min-h-screen flex items-center justify-center p-4">
<div
    class="max-w-[1000px] w-full bg-[#1E293B] rounded-[2rem] shadow-2xl overflow-hidden border border-slate-700 p-8 lg:p-16 text-center relative">

    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full bg-slate-900/50 pointer-events-none"></div>
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl opacity-30"></div>

    <div class="mb-6 relative z-10">
            <span
                class="px-4 py-1.5 bg-slate-800 text-[#38BDF8] text-sm font-bold rounded-full uppercase tracking-wider border border-slate-600">
                Hospital App v1.0
            </span>
    </div>
    <h1 class="text-4xl lg:text-6xl font-extrabold text-white mb-6 leading-tight relative z-10">
        رعايتك الصحية <br/>
        <span class="text-[#38BDF8] glow-text">أسهل، أسرع، وأكثر أماناً.</span>
    </h1>
    <p class="text-lg text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
        احجز مواعيدك الطبية، تواصل مع أطبائك، وتابع ملفك الصحي بكل سهولة وخصوصية تامة.
    </p>

    <div class="flex flex-wrap gap-4 justify-center relative z-10 mb-12">
        <a href="http://127.0.0.1:8000/docs/api#/"
           class="px-8 py-4 hospital-gradient text-white font-bold rounded-xl hover:opacity-90 transition-all active:scale-95 flex items-center gap-2 text-lg shadow-lg shadow-blue-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            توثيق الـ API
        </a>
    </div>

    <!-- Developer Commands Section -->
    <div
        class="mb-12 relative z-10 text-right bg-[#0F172A] p-6 rounded-2xl border border-slate-700 hover:border-[#38BDF8]/30 transition-colors">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            أوامر التشغيل (Setup Commands)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
                class="flex items-center justify-between bg-black/40 p-4 rounded-xl border border-slate-700 hover:border-[#38BDF8]/30 transition-all group">
                <code class="text-sm text-[#38BDF8] font-mono font-bold group-hover:text-cyan-300 transition-colors"
                      dir="ltr">php artisan serve</code>
                <span class="text-xs text-slate-500">تشغيل السيرفر (Backend)</span>
            </div>
            <div
                class="flex items-center justify-between bg-black/40 p-4 rounded-xl border border-slate-700 hover:border-[#38BDF8]/30 transition-all group">
                <code class="text-sm text-[#38BDF8] font-mono font-bold group-hover:text-cyan-300 transition-colors"
                      dir="ltr">php artisan queue:work</code>
                <span class="text-xs text-slate-500">تشغيل الكيو (Emails)</span>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right relative z-10">
        <div
            class="p-6 bg-[#0F172A] rounded-2xl border border-slate-700 hover:border-[#38BDF8]/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all group">
            <div
                class="text-[#38BDF8] mb-4 flex justify-center md:justify-start group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">حجز فوري</h3>
            <p class="text-sm text-slate-400">اختر الطبيب المناسب واحجز موعدك في ثوانٍ معدودة.</p>
        </div>
        <div
            class="p-6 bg-[#0F172A] rounded-2xl border border-slate-700 hover:border-[#38BDF8]/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all group">
            <div
                class="text-[#38BDF8] mb-4 flex justify-center md:justify-start group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">ملف طبي شامل</h3>
            <p class="text-sm text-slate-400">احتفظ بجميع تقاريرك الطبية وتاريخك المرضي في مكان واحد آمن.</p>
        </div>
        <div
            class="p-6 bg-[#0F172A] rounded-2xl border border-slate-700 hover:border-[#38BDF8]/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all group">
            <div
                class="text-[#38BDF8] mb-4 flex justify-center md:justify-start group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">أمان وخصوصية</h3>
            <p class="text-sm text-slate-400">بياناتك مشفرة ومحمية بأحدث تقنيات الأمان والتحقق الثنائي.</p>
        </div>
    </div>
</div>
</body>
</html>
