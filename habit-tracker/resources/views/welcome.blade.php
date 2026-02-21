<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HabitSync - متتبع العادات الذكي</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=alexandria:400,500,600,700,900&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Alexandria', sans-serif;
        }

        .habit-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.6);
        }

        .glow-text {
            text-shadow: 0 0 15px rgba(14, 165, 233, 0.8);
        }
    </style>
</head>
<body class="bg-[#1a1a1a] min-h-screen flex items-center justify-center p-4 overflow-hidden relative">

    <!-- Dot Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-20"
         style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;">
    </div>

    <div class="max-w-[1100px] w-full bg-[#242424]/80 backdrop-blur-xl rounded-[3rem] shadow-2xl overflow-hidden border border-white/10 p-8 lg:p-16 text-center relative z-10">

        <!-- Header Badge -->
        <div class="mb-8 relative z-10">
            <span class="px-6 py-2 bg-[#0ea5e9]/10 text-[#0ea5e9] text-sm font-black rounded-full uppercase tracking-widest border border-[#0ea5e9]/20">
                HabitSync v1.0
            </span>
        </div>

        <!-- Main Title -->
        <h1 class="text-5xl lg:text-7xl font-black text-white mb-6 leading-tight relative z-10 tracking-tighter">
            ابنِ عاداتك <br/>
            <span class="text-[#0ea5e9] glow-text">اصنع مستقبلك.</span>
        </h1>

        <!-- Description -->
        <p class="text-xl text-gray-400 mb-10 max-w-3xl mx-auto relative z-10 font-medium leading-relaxed">
            تتبع عاداتك اليومية، حافظ على الـ Streak، وارفع مستواك (Level Up) مع نظام تحليل ذكي وتنبيهات لحظية.
        </p>

        <!-- CTA Button -->
        <div class="flex flex-wrap gap-4 justify-center relative z-10 mb-16">
            <a href="{{ route('habits.index') }}"
               class="px-10 py-5 habit-gradient text-white font-black rounded-2xl hover:scale-105 transition-all active:scale-95 flex items-center gap-3 text-xl shadow-xl shadow-[#0ea5e9]/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                ابدأ رحلتك الآن
            </a>
        </div>

        <!-- Developer Commands Section -->
        <div class="mb-16 relative z-10 text-right bg-[#1a1a1a] p-8 rounded-[2rem] border border-white/5 hover:border-[#0ea5e9]/30 transition-colors shadow-lg">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <svg class="w-6 h-6 text-[#0ea5e9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                أوامر التشغيل (Setup Commands)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center justify-between bg-black/40 p-5 rounded-2xl border border-white/5 hover:border-[#0ea5e9]/30 transition-all group">
                    <code class="text-base text-[#0ea5e9] font-mono font-bold group-hover:text-white transition-colors" dir="ltr">php artisan serve</code>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Backend Server</span>
                </div>
                <div class="flex items-center justify-between bg-black/40 p-5 rounded-2xl border border-white/5 hover:border-[#0ea5e9]/30 transition-all group">
                    <code class="text-base text-[#0ea5e9] font-mono font-bold group-hover:text-white transition-colors" dir="ltr">npm run dev</code>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Frontend (Vite)</span>
                </div>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right relative z-10">
            <!-- Feature 1 -->
            <div class="p-8 bg-[#1a1a1a] rounded-[2rem] border border-white/5 hover:border-[#0ea5e9]/30 transition-all group hover:-translate-y-2 duration-300">
                <div class="w-14 h-14 bg-[#0ea5e9]/10 rounded-2xl flex items-center justify-center text-[#0ea5e9] mb-6 group-hover:bg-[#0ea5e9] group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white mb-3">تحليلات دقيقة</h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">راقب تقدمك عبر رسوم بيانية تفاعلية واعرف أيام نشاطك.</p>
            </div>

            <!-- Feature 2 -->
            <div class="p-8 bg-[#1a1a1a] rounded-[2rem] border border-white/5 hover:border-[#0ea5e9]/30 transition-all group hover:-translate-y-2 duration-300">
                <div class="w-14 h-14 bg-[#0ea5e9]/10 rounded-2xl flex items-center justify-center text-[#0ea5e9] mb-6 group-hover:bg-[#0ea5e9] group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white mb-3">نظام الـ Streak</h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">حافظ على سلسلة انتصاراتك ولا تكسر الروتين اليومي.</p>
            </div>

            <!-- Feature 3 -->
            <div class="p-8 bg-[#1a1a1a] rounded-[2rem] border border-white/5 hover:border-[#0ea5e9]/30 transition-all group hover:-translate-y-2 duration-300">
                <div class="w-14 h-14 bg-[#0ea5e9]/10 rounded-2xl flex items-center justify-center text-[#0ea5e9] mb-6 group-hover:bg-[#0ea5e9] group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white mb-3">Gamification</h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">اجمع نقاط الخبرة (XP) وارفع مستواك مع كل إنجاز.</p>
            </div>
        </div>
    </div>
</body>
</html>
