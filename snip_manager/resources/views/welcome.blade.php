<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مجرة الأكواد | Code Galaxy</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #030303;
            color: #fff;
            font-family: 'Tajawal', sans-serif;
            overflow-x: hidden;
        }
        .mono { font-family: 'Space Mono', monospace; }

        /* شبكة السايبربانك الخلفية */
        .cyber-grid {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background-image: linear-gradient(rgba(0, 255, 204, 0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(0, 255, 204, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
            pointer-events: none;
        }

        /* كرت الهولوجرام السحري */
        .holo-card {
            background: rgba(10, 10, 10, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        /* خط النيون العلوي الديناميكي */
        .holo-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 2px;
            background: var(--neon);
            box-shadow: 0 0 15px var(--neon), 0 0 30px var(--neon);
            opacity: 0; transition: opacity 0.3s ease;
        }

        .holo-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px -10px var(--neon);
        }
        .holo-card:hover::before { opacity: 1; }

        /* تأثير الاختراق (Glitch) عند النسخ */
        .glitch-anim { animation: glitch 0.2s linear infinite; }
        @keyframes glitch {
            0% { transform: translate(0) }
            20% { transform: translate(-3px, 3px) filter: hue-rotate(90deg); }
            40% { transform: translate(-3px, -3px) }
            60% { transform: translate(3px, 3px) filter: invert(1); }
            80% { transform: translate(3px, -3px) }
            100% { transform: translate(0) }
        }

        /* سكرول بار تقني */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen relative p-6 md:p-12 selection:bg-cyan-500 selection:text-black">

    <div class="cyber-grid"></div>

    <header class="mb-20 text-center gs-reveal flex flex-col items-center">
        <div class="inline-block border border-gray-800 bg-black/50 px-4 py-1 rounded-full mb-6 backdrop-blur-md">
            <span class="mono text-xs text-green-400 tracking-widest uppercase animate-pulse">● SYSTEM_ONLINE</span>
        </div>
        <h1 class="text-6xl md:text-8xl font-black mb-4 tracking-tighter drop-shadow-2xl">
            مجرة <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-600">الأكواد</span>
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">مستودع الشفرات البرمجية. اخترق النظام، انسخ الكود، وابنِ المستقبل.</p>
    </header>

    <main class="max-w-7xl mx-auto space-y-24">

        @foreach($groupedCategories as $type => $categories)
            <section class="gs-reveal">

                <div class="flex items-center gap-6 mb-10">
                    <h2 class="mono text-3xl font-bold uppercase tracking-widest text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]">
                        /> {{ $type }}
                    </h2>
                    <div class="h-[1px] flex-1 bg-gradient-to-l from-gray-800 to-transparent"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        @foreach($category->snippets as $snippet)

                            <div class="holo-card p-6 rounded-xl cursor-crosshair group flex flex-col"
                                 style="--neon: {{ $category->color }};"
                                 onclick="copyCode(this, '{{ base64_encode($snippet->code) }}')">

                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-black/50 p-2 rounded-lg border border-gray-800 group-hover:border-[var(--neon)] transition-colors">
                                            <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="w-8 h-8 filter drop-shadow-[0_0_5px_var(--neon)]">
                                        </div>
                                        <h3 class="text-xl font-bold leading-tight" style="color: {{ $category->color }}">{{ $snippet->title }}</h3>
                                    </div>
                                    <span class="mono text-[10px] text-gray-500 border border-gray-800 px-2 py-1 rounded-full uppercase">{{ $category->name }}</span>
                                </div>

                                <p class="text-gray-400 text-sm mb-6 flex-1 line-clamp-2">{{ $snippet->description }}</p>

                                <div class="relative bg-black/80 border border-gray-800 rounded-lg p-4 overflow-hidden group-hover:border-[var(--neon)] transition-colors h-32">
                                    <pre class="mono text-xs text-gray-300 overflow-hidden"><code class="language-{{ $snippet->language }}">{{ $snippet->code }}</code></pre>

                                    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <span class="copy-text mono text-sm font-bold tracking-widest" style="color: {{ $category->color }}">
                                            [ انقر للاستخراج ]
                                        </span>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endforeach
                </div>
            </section>
        @endforeach

    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        // 1. أنيميشن الدخول السينمائي للعناصر
        gsap.from(".gs-reveal", {
            y: 60,
            opacity: 0,
            duration: 1.2,
            stagger: 0.2,
            ease: "power4.out",
        });

        // 2. دالة استخراج الكود وتأثير الـ Glitch
        function copyCode(card, base64Code) {
            // فك تشفير الكود من الـ Base64
            const code = decodeURIComponent(escape(atob(base64Code)));

            // نسخ الكود للحافظة
            navigator.clipboard.writeText(code).then(() => {

                // تشغيل تأثير الاختراق البصري
                card.classList.add('glitch-anim');

                // تغيير النص واللون
                const textEl = card.querySelector('.copy-text');
                const originalText = textEl.innerText;
                const neonColor = card.style.getPropertyValue('--neon');

                textEl.innerText = 'ACCESS GRANTED // تم النسخ';
                textEl.style.color = '#fff';
                textEl.style.textShadow = `0 0 10px ${neonColor}`;

                // إرجاع الكرت لحالته الطبيعية بعد نصف ثانية
                setTimeout(() => {
                    card.classList.remove('glitch-anim');
                    textEl.innerText = originalText;
                    textEl.style.color = neonColor;
                    textEl.style.textShadow = 'none';
                }, 600);
            });
        }
    </script>
</body>
</html>
