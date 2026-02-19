<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sticky Notes - لوحة الملاحظات الذكية</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=alexandria:400,500,600,700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Alexandria', sans-serif;
        }

        .notes-gradient {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            box-shadow: 0 0 20px rgba(251, 191, 36, 0.6);
        }

        .glow-text {
            text-shadow: 0 0 15px rgba(251, 191, 36, 0.8);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-[#050505] min-h-screen flex items-center justify-center p-4">
<div
    class="max-w-[1000px] w-full bg-white dark:bg-[#0a0a0a] rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100 dark:border-yellow-500/20 p-8 lg:p-16 text-center relative">

    <!-- Background Glow Effect -->
    <div class="absolute top-0 left-0 w-full h-full bg-yellow-500/5 pointer-events-none"></div>

    <div class="mb-6 relative z-10">
            <span
                class="px-4 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-sm font-bold rounded-full uppercase tracking-wider border border-yellow-200 dark:border-yellow-500/30">
                Sticky Notes v1.0
            </span>
    </div>
    <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-6 leading-tight relative z-10">
        لوحة ملاحظاتك <br/>
        <span class="text-yellow-500 dark:text-yellow-400 glow-text">بسيطة، جميلة، ومنظمة.</span>
    </h1>
    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto relative z-10">
        دون أفكارك، مهامك، وملاحظاتك اليومية في مكان واحد بتصميم تفاعلي يشبه السبورة الحقيقية.
    </p>

    <div class="flex flex-wrap gap-4 justify-center relative z-10 mb-12">
        <a href="{{ route('notes.index') }}"
           class="px-8 py-4 notes-gradient text-white font-bold rounded-xl hover:opacity-90 transition-all active:scale-95 flex items-center gap-2 text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            ابدأ التدوين الآن
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right relative z-10">
        <div
            class="p-6 bg-gray-50 dark:bg-[#111] rounded-2xl border border-transparent dark:border-yellow-500/10 hover:border-yellow-500/30 transition-all">
            <div class="text-yellow-500 mb-4 flex justify-center md:justify-start">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">تنظيم سهل</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">رتب أفكارك في بطاقات ملونة وجذابة بصرياً.</p>
        </div>
        <div
            class="p-6 bg-gray-50 dark:bg-[#111] rounded-2xl border border-transparent dark:border-yellow-500/10 hover:border-yellow-500/30 transition-all">
            <div class="text-yellow-400 mb-4 flex justify-center md:justify-start">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">تعديل فوري</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">أضف وعدل واحذف ملاحظاتك بسرعة وسهولة تامة.</p>
        </div>
        <div
            class="p-6 bg-gray-50 dark:bg-[#111] rounded-2xl border border-transparent dark:border-yellow-500/10 hover:border-yellow-500/30 transition-all">
            <div class="text-yellow-600 mb-4 flex justify-center md:justify-start">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">تجربة ممتعة</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">واجهة مستخدم تفاعلية تجعل التدوين أمراً ممتعاً.</p>
        </div>
    </div>
</div>
</body>
</html>
