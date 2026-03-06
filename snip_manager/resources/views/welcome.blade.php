<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNIP_MANAGER // PRO</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700;900&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">

    <!-- مكتبة الأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-dark: #0a0a0a;
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-bg: rgba(20, 20, 20, 0.6);
        }

        body {
            background-color: var(--bg-dark);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        .font-code { font-family: 'Fira Code', monospace; }

        /* خلفية الأجرام السماوية المتحركة */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: float 10s infinite ease-in-out alternate;
            opacity: 0.4;
        }
        .orb-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: #4f46e5; animation-delay: 0s; }
        .orb-2 { bottom: -10%; right: -10%; width: 40vw; height: 40vw; background: #ec4899; animation-delay: -5s; }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, 50px) scale(1.1); }
        }

        /* كرت الزجاج المتطور */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transform-style: preserve-3d;
            transform: perspective(1000px);
        }

        /* تأثير التوهج عند الهوفر */
        .glow-hover {
            position: relative;
            overflow: hidden;
        }
        .glow-hover::after {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: skewX(-25deg);
            transition: 0.5s;
        }
        .glow-hover:hover::after { left: 150%; }

        /* شريط التمرير */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f0f0f; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }

        /* تأثير النص المتدرج */
        .text-gradient {
            background: linear-gradient(to right, #4f46e5, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen pb-20">

    <!-- الخلفية المتحركة -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- الهيدر -->
    <header class="pt-16 pb-12 px-6 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-6 backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-xs font-code tracking-widest text-gray-300">V2.0.0 ONLINE</span>
        </div>

        <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">
            مكتبة <span class="text-gradient">النخبة</span>
        </h1>

        <!-- مربع البحث الذكي -->
        <div class="max-w-xl mx-auto relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-pink-500 rounded-xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="ابحث عن كود، لغة، أو وصف..."
                       class="w-full bg-[#111] text-white border border-white/10 rounded-xl px-6 py-4 pl-12 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-code text-sm shadow-2xl">
                <i class="fa-solid fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 space-y-16 relative z-10">

        @foreach($groupedCategories as $type => $categories)
            <section class="category-section">
                <!-- عنوان القسم -->
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-10 w-1 bg-gradient-to-b from-indigo-500 to-pink-500 rounded-full"></div>
                    <h2 class="text-3xl font-bold uppercase tracking-wider text-white/90">{{ $type }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        @foreach($category->snippets as $snippet)

                            <!-- الكرت بتقنية Tilt 3D -->
                            <div class="glass-card rounded-2xl p-1 snippet-card group" data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-glare data-tilt-max-glare="0.1">
                                <div class="bg-[#0f0f0f]/80 h-full rounded-xl p-6 flex flex-col relative overflow-hidden border border-white/5">

                                    <!-- إضاءة خلفية خفيفة بلون اللغة -->
                                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full blur-[60px] opacity-20 transition-opacity group-hover:opacity-40" style="background: {{ $category->color }}"></div>

                                    <!-- رأس الكرت -->
                                    <div class="flex justify-between items-start mb-6 relative z-10">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center border border-white/10 shadow-inner">
                                                <img src="{{ $category->icon }}" class="w-6 h-6">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-lg leading-tight text-gray-100 snippet-title">{{ $snippet->title }}</h3>
                                                <span class="text-xs text-gray-500 font-code">{{ $category->name }}</span>
                                            </div>
                                        </div>

                                        <!-- زر النسخ -->
                                        <button onclick="copyCode(this, '{{ base64_encode($snippet->code) }}')"
                                                class="w-8 h-8 rounded-full bg-white/5 hover:bg-indigo-500 hover:text-white flex items-center justify-center transition-all duration-300 border border-white/10 group-hover:border-indigo-400">
                                            <i class="fa-regular fa-copy text-sm"></i>
                                        </button>
                                    </div>

                                    <!-- الوصف -->
                                    <p class="text-gray-400 text-sm mb-5 line-clamp-2 snippet-desc">{{ $snippet->description }}</p>

                                    <!-- محرر الكود الوهمي -->
                                    <div class="mt-auto rounded-lg overflow-hidden border border-white/10 bg-[#050505] shadow-2xl">
                                        <!-- شريط المحرر -->
                                        <div class="bg-[#1a1a1a] px-3 py-2 flex items-center gap-1.5 border-b border-white/5">
                                            <div class="w-2.5 h-2.5 rounded-full bg-[#ff5f56]"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-[#ffbd2e]"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-[#27c93f]"></div>
                                            <span class="ml-auto text-[10px] text-gray-600 font-code">main.{{ $snippet->language == 'php' ? 'php' : ($snippet->language == 'javascript' ? 'js' : 'sql') }}</span>
                                        </div>
                                        <!-- منطقة الكود -->
                                        <div class="p-4 overflow-x-auto custom-scrollbar">
                                            <pre class="font-code text-xs text-gray-300 leading-relaxed"><code class="language-{{ $snippet->language }}">{{ $snippet->code }}</code></pre>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        @endforeach
                    @endforeach
                </div>
            </section>
        @endforeach

        <!-- رسالة لا توجد نتائج -->
        <div id="noResults" class="hidden text-center py-20">
            <i class="fa-solid fa-ghost text-6xl text-gray-700 mb-4 animate-bounce"></i>
            <p class="text-gray-500 font-code">No signals found in the void...</p>
        </div>

    </main>

    <!-- مكتبة Tilt.js للتأثير ثلاثي الأبعاد -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>

    <script>
        // 1. تفعيل تأثير الإمالة 3D
        VanillaTilt.init(document.querySelectorAll(".glass-card"), {
            max: 10,
            speed: 400,
            glare: true,
            "max-glare": 0.1,
            scale: 1.02
        });

        // 2. وظيفة البحث الفوري
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.snippet-card');
        const noResults = document.getElementById('noResults');

        searchInput.addEventListener('keyup', (e) => {
            const term = e.target.value.toLowerCase();
            let hasResults = false;

            cards.forEach(card => {
                const title = card.querySelector('.snippet-title').innerText.toLowerCase();
                const desc = card.querySelector('.snippet-desc').innerText.toLowerCase();

                if (title.includes(term) || desc.includes(term)) {
                    card.style.display = "block";
                    hasResults = true;
                } else {
                    card.style.display = "none";
                }
            });

            // إخفاء الأقسام الفارغة
            document.querySelectorAll('.category-section').forEach(section => {
                const visibleCards = section.querySelectorAll('.snippet-card[style="display: block;"]');
                if (visibleCards.length === 0 && term !== '') {
                    section.style.display = 'none';
                } else {
                    section.style.display = 'block';
                }
            });

            noResults.style.display = hasResults ? 'none' : 'block';
        });

        // 3. وظيفة النسخ الاحترافية
        function copyCode(btn, base64Code) {
            const code = decodeURIComponent(escape(atob(base64Code)));
            navigator.clipboard.writeText(code).then(() => {
                const originalIcon = btn.innerHTML;

                // تغيير الأيقونة واللون
                btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                btn.classList.add('bg-green-500', 'text-white', 'border-green-400');
                btn.classList.remove('bg-white/5');

                setTimeout(() => {
                    btn.innerHTML = originalIcon;
                    btn.classList.remove('bg-green-500', 'text-white', 'border-green-400');
                    btn.classList.add('bg-white/5');
                }, 2000);
            });
        }
    </script>
</body>
</html>
