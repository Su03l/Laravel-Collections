<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo Master - لوحة المهام الذكية</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=alexandria:400,500,600,700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Alexandria', sans-serif;
        }

        .notes-gradient {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.6);
        }

        .glow-text {
            text-shadow: 0 0 15px rgba(6, 182, 212, 0.8);
        }
    </style>
</head>
<body class="bg-[#1a1a1a] min-h-screen flex items-center justify-center p-4">
<div
    class="max-w-[1000px] w-full bg-[#252525]/60 backdrop-blur-xl rounded-[2rem] shadow-2xl overflow-hidden border border-white/10 p-8 lg:p-16 text-center relative">

    <!-- Background Glow Effect -->
    <div class="absolute top-0 left-0 w-full h-full bg-cyan-500/5 pointer-events-none"></div>

    <div class="mb-6 relative z-10">
            <span
                class="px-4 py-1.5 bg-cyan-900/30 text-cyan-400 text-sm font-bold rounded-full uppercase tracking-wider border border-cyan-500/30">
                Todo Master v1.0
            </span>
    </div>
    <h1 class="text-4xl lg:text-6xl font-extrabold text-white mb-6 leading-tight relative z-10">
        لوحة مهامك <br/>
        <span class="text-cyan-400 glow-text">ذكية، منظمة، وممتعة.</span>
    </h1>
    <p class="text-lg text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
        رتب يومك، حدد أولوياتك، وأنجز مهامك بأسلوب عصري وتفاعلي مع دعم السحب والإفلات والتصنيفات الذكية.
    </p>

    <div class="flex flex-col items-center gap-6 relative z-10 mb-12">
        <a href="{{ route('todos.index') }}"
           class="px-8 py-4 notes-gradient text-white font-bold rounded-xl hover:opacity-90 transition-all active:scale-95 flex items-center gap-2 text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            ابدأ التنظيم الآن
        </a>

        <!-- Commands Section -->
        <div class="flex flex-col gap-2 text-left" dir="ltr">
            <div class="bg-black/40 border border-white/10 rounded-lg px-4 py-2 font-mono text-sm text-slate-300 flex items-center gap-3">
                <span class="text-cyan-500">$</span>
                <span>php artisan serve</span>
            </div>
            <div class="bg-black/40 border border-white/10 rounded-lg px-4 py-2 font-mono text-sm text-slate-300 flex items-center gap-3">
                <span class="text-cyan-500">$</span>
                <span>npm run dev</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right relative z-10">
        <div
            class="p-6 bg-[#1a1a1a] rounded-2xl border border-white/5 hover:border-cyan-500/30 transition-all">
            <div class="text-cyan-500 mb-4 flex justify-center md:justify-start">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">سحب وإفلات</h3>
            <p class="text-sm text-slate-400">رتب مهامك وأولوياتك بسهولة تامة عبر السحب والإفلات.</p>
        </div>
        <div
            class="p-6 bg-[#1a1a1a] rounded-2xl border border-white/5 hover:border-cyan-500/30 transition-all">
            <div class="text-cyan-400 mb-4 flex justify-center md:justify-start">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">تصنيفات ذكية</h3>
            <p class="text-sm text-slate-400">نظم مهامك باستخدام تصنيفات ملونة (عمل، شخصي، رياضة...).</p>
        </div>
        <div
            class="p-6 bg-[#1a1a1a] rounded-2xl border border-white/5 hover:border-cyan-500/30 transition-all">
            <div class="text-cyan-600 mb-4 flex justify-center md:justify-start">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">بحث وفلترة</h3>
            <p class="text-sm text-slate-400">اعثر على أي مهمة بسرعة فائقة باستخدام البحث والفلترة المتقدمة.</p>
        </div>
    </div>
</div>
</body>
</html>
