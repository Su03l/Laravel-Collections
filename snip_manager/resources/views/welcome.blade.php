<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNIP_MANAGER // PRO</title>
    <meta name="description" content="مكتبة أكواد احترافية - اكتشف وانسخ أفضل الأكواد البرمجية بضغطة زر">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Prism.js للـ Syntax Highlighting --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                        code: ['Fira Code', 'monospace'],
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --bg-primary: #06060a;
            --bg-secondary: #0c0c14;
            --bg-card: rgba(14, 14, 25, 0.7);
            --border-subtle: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --accent-cyan: #06b6d4;
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --accent-pink: #ec4899;
            --accent-emerald: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-primary);
            color: #e2e8f0;
            font-family: 'Outfit', 'Inter', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* ═══════════ خلفية الجزيئات ═══════════ */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* ═══════════ الأجرام المتحركة ═══════════ */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            opacity: 0.25;
            animation: orbFloat 15s infinite ease-in-out alternate;
        }

        .orb-1 {
            top: -15%;
            right: -10%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, #4f46e5, #06b6d4);
            animation-delay: 0s;
        }

        .orb-2 {
            bottom: -15%;
            left: -10%;
            width: 40vw;
            height: 40vw;
            background: radial-gradient(circle, #ec4899, #8b5cf6);
            animation-delay: -7s;
        }

        .orb-3 {
            top: 40%;
            left: 50%;
            width: 25vw;
            height: 25vw;
            background: radial-gradient(circle, #10b981, #06b6d4);
            animation-delay: -3s;
            opacity: 0.12;
        }

        @keyframes orbFloat {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }

            100% {
                transform: translate(40px, 60px) scale(1.15) rotate(5deg);
            }
        }

        /* ═══════════ النافبار ═══════════ */
        .navbar {
            background: rgba(6, 6, 10, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-subtle);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(6, 6, 10, 0.92);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        /* ═══════════ تأثير التدرج المتحرك ═══════════ */
        .gradient-text {
            background: linear-gradient(135deg, #06b6d4, #3b82f6, #8b5cf6, #ec4899, #06b6d4);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 6s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* ═══════════ كرت الزجاج ═══════════ */
        .snippet-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .snippet-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--card-accent, #3b82f6), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .snippet-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-4px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4),
                0 0 40px var(--card-glow, rgba(59, 130, 246, 0.08));
        }

        .snippet-card:hover::before {
            opacity: 1;
        }

        /* ═══════════ زر النسخ ═══════════ */
        .copy-btn {
            position: relative;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            background: rgba(59, 130, 246, 0.15) !important;
            border-color: rgba(59, 130, 246, 0.4) !important;
            transform: scale(1.1);
        }

        .copy-btn .tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1e293b;
            color: #e2e8f0;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            margin-bottom: 6px;
        }

        .copy-btn:hover .tooltip {
            opacity: 1;
        }

        /* ═══════════ فلاتر اللغات ═══════════ */
        .filter-btn {
            transition: all 0.3s ease;
            position: relative;
        }

        .filter-btn.active {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.5);
            color: #60a5fa;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.1);
        }

        .filter-btn:hover:not(.active) {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
        }

        /* ═══════════ إحصائيات ═══════════ */
        .stat-card {
            background: rgba(14, 14, 25, 0.5);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--border-hover);
            background: rgba(14, 14, 25, 0.7);
            transform: translateY(-2px);
        }

        /* ═══════════ منطقة الكود ═══════════ */
        .code-block {
            background: #0a0a12 !important;
            border-radius: 10px;
            border: 1px solid var(--border-subtle);
            overflow: hidden;
        }

        .code-block pre {
            margin: 0 !important;
            padding: 16px !important;
            background: transparent !important;
            font-size: 12px !important;
            line-height: 1.7 !important;
        }

        .code-block pre code {
            font-family: 'Fira Code', monospace !important;
            font-size: 12px !important;
            text-shadow: none !important;
        }

        /* editor dots */
        .editor-dots {
            display: flex;
            gap: 6px;
            padding: 10px 14px;
            background: rgba(15, 15, 25, 0.8);
            border-bottom: 1px solid var(--border-subtle);
        }

        .editor-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* ═══════════ أنيميشن الظهور ═══════════ */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ═══════════ شريط التمرير ═══════════ */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        /* ═══════════ البحث ═══════════ */
        .search-wrapper {
            position: relative;
        }

        .search-wrapper::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6, #8b5cf6);
            border-radius: 16px;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }

        .search-wrapper:focus-within::before {
            opacity: 0.6;
        }

        /* ═══════════ Badge اللغة ═══════════ */
        .lang-badge {
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-family: 'Fira Code', monospace;
        }

        /* ═══════════ pulse ring ═══════════ */
        .pulse-ring {
            animation: pulseRing 2s infinite;
        }

        @keyframes pulseRing {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* ═══════════ Floating tag ═══════════ */
        .floating-tag {
            animation: floatTag 3s ease-in-out infinite alternate;
        }

        @keyframes floatTag {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-6px);
            }
        }
    </style>
</head>

<body>

    {{-- ═══════════ خلفية الجزيئات ═══════════ --}}
    <canvas id="particles-canvas"></canvas>

    {{-- ═══════════ الأجرام ═══════════ --}}
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    {{-- ════════════════════════════════════════════════════════════════
         النافبار الثابت
    ════════════════════════════════════════════════════════════════ --}}
    <nav class="navbar fixed top-0 left-0 right-0 z-50 px-6 py-4" id="navbar">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            {{-- اللوقو --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                    <i class="fa-solid fa-code text-white text-sm"></i>
                </div>
                <span class="font-bold text-lg tracking-tight text-white">SNIP<span class="text-cyan-400">_</span>MGR</span>
            </div>

            {{-- الحالة + العداد --}}
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/[0.03] border border-white/[0.06]">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-ring"></span>
                    <span class="text-xs font-code text-gray-400">v2.0</span>
                </div>
                @php
                $totalSnippets = 0;
                $languages = [];
                foreach($groupedCategories as $cats) {
                foreach($cats as $cat) {
                $totalSnippets += $cat->snippets->count();
                foreach($cat->snippets as $s) {
                $languages[$s->language] = true;
                }
                }
                }
                @endphp
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/[0.03] border border-white/[0.06]">
                    <i class="fa-solid fa-layer-group text-xs text-blue-400"></i>
                    <span class="text-xs font-code text-gray-400">{{ $totalSnippets }} كود</span>
                </div>
            </div>
        </div>
    </nav>

    {{-- ════════════════════════════════════════════════════════════════
         قسم الهيرو
    ════════════════════════════════════════════════════════════════ --}}
    <header class="relative z-10 pt-32 pb-10 px-6">
        <div class="max-w-4xl mx-auto text-center">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/[0.04] border border-white/[0.08] mb-8 floating-tag">
                <i class="fa-solid fa-sparkles text-cyan-400 text-xs"></i>
                <span class="text-xs font-code tracking-widest text-gray-400">PROFESSIONAL SNIPPET LIBRARY</span>
            </div>

            {{-- العنوان الرئيسي --}}
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black mb-6 leading-[1.1] tracking-tight">
                مكتبة <span class="gradient-text">النخبة</span>
            </h1>

            {{-- وصف فرعي --}}
            <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                اكتشف، انسخ، واستخدم أفضل الأكواد البرمجية المنظمة
                <br class="hidden sm:block">
                بضغطة زر واحدة <span class="text-cyan-400">⚡</span>
            </p>

            {{-- الإحصائيات --}}
            <div class="flex flex-wrap justify-center gap-4 sm:gap-6 mb-12">
                <div class="stat-card px-5 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cyan-500/10 flex items-center justify-center">
                        <i class="fa-solid fa-code text-cyan-400 text-sm"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-bold text-white">{{ $totalSnippets }}</div>
                        <div class="text-[11px] text-gray-500 font-code">أكواد</div>
                    </div>
                </div>
                <div class="stat-card px-5 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                        <i class="fa-solid fa-language text-blue-400 text-sm"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-bold text-white">{{ count($languages) }}</div>
                        <div class="text-[11px] text-gray-500 font-code">لغات</div>
                    </div>
                </div>
                <div class="stat-card px-5 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                        <i class="fa-solid fa-folder-tree text-purple-400 text-sm"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-bold text-white">{{ $groupedCategories->count() }}</div>
                        <div class="text-[11px] text-gray-500 font-code">أقسام</div>
                    </div>
                </div>
            </div>

            {{-- شريط البحث --}}
            <div class="max-w-2xl mx-auto search-wrapper">
                <div class="relative">
                    <input type="text" id="searchInput"
                        placeholder="🔍  ابحث عن كود، لغة، أو وصف..."
                        class="w-full bg-[#0c0c18] text-white border border-white/[0.08] rounded-2xl px-6 py-4 pr-14 focus:outline-none focus:border-transparent transition-all font-code text-sm shadow-2xl placeholder:text-gray-600">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-2">
                        <kbd class="hidden sm:inline-block text-[10px] font-code text-gray-600 bg-white/[0.04] border border-white/[0.08] rounded px-1.5 py-0.5">/</kbd>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ════════════════════════════════════════════════════════════════
         فلاتر اللغات
    ════════════════════════════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-6 mb-12 relative z-10">
        <div class="flex flex-wrap justify-center gap-2" id="filters">
            <button class="filter-btn active px-4 py-2 rounded-full text-sm border border-white/[0.08] bg-white/[0.03] text-gray-300 font-medium" data-filter="all">
                <i class="fa-solid fa-grid-2 ml-1 text-xs"></i> الكل
            </button>
            @foreach($groupedCategories->keys() as $type)
            <button class="filter-btn px-4 py-2 rounded-full text-sm border border-white/[0.08] bg-white/[0.03] text-gray-400 font-medium" data-filter="{{ $type }}">
                @if($type === 'frontend' || $type === 'Frontend')
                <i class="fa-solid fa-palette ml-1 text-xs text-cyan-400"></i>
                @elseif($type === 'backend' || $type === 'Backend')
                <i class="fa-solid fa-server ml-1 text-xs text-blue-400"></i>
                @elseif($type === 'database' || $type === 'Database')
                <i class="fa-solid fa-database ml-1 text-xs text-purple-400"></i>
                @else
                <i class="fa-solid fa-tag ml-1 text-xs text-gray-400"></i>
                @endif
                {{ $type }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════
         محتوى الأكواد
    ════════════════════════════════════════════════════════════════ --}}
    <main class="max-w-7xl mx-auto px-6 pb-20 relative z-10 space-y-16">

        @foreach($groupedCategories as $type => $categories)
        <section class="category-section reveal" data-type="{{ $type }}">
            {{-- عنوان القسم --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-8 rounded-full bg-gradient-to-b from-cyan-500 to-blue-600"></div>
                    <h2 class="text-2xl font-bold tracking-wide text-white/90">{{ $type }}</h2>
                </div>
                <div class="flex-1 h-px bg-gradient-to-l from-transparent to-white/[0.06]"></div>
                <span class="text-xs font-code text-gray-600 bg-white/[0.03] border border-white/[0.06] px-3 py-1 rounded-full">
                    {{ $categories->sum(fn($c) => $c->snippets->count()) }} كود
                </span>
            </div>

            {{-- شبكة الكروت --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                @foreach($category->snippets as $snippet)
                @php
                $accentColors = [
                'php' => ['border' => '#8b5cf6', 'bg' => 'rgba(139,92,246,0.1)', 'glow' => 'rgba(139,92,246,0.06)'],
                'javascript' => ['border' => '#eab308', 'bg' => 'rgba(234,179,8,0.1)', 'glow' => 'rgba(234,179,8,0.06)'],
                'sql' => ['border' => '#06b6d4', 'bg' => 'rgba(6,182,212,0.1)', 'glow' => 'rgba(6,182,212,0.06)'],
                'css' => ['border' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.1)', 'glow' => 'rgba(59,130,246,0.06)'],
                'python' => ['border' => '#10b981', 'bg' => 'rgba(16,185,129,0.1)', 'glow' => 'rgba(16,185,129,0.06)'],
                ];
                $accent = $accentColors[$snippet->language] ?? ['border' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.1)', 'glow' => 'rgba(59,130,246,0.06)'];
                @endphp

                <div class="snippet-card p-6 flex flex-col"
                    style="--card-accent: {{ $accent['border'] }}; --card-glow: {{ $accent['glow'] }}"
                    data-title="{{ $snippet->title }}"
                    data-desc="{{ $snippet->description }}"
                    data-lang="{{ $snippet->language }}">

                    {{-- الإضاءة الخلفية --}}
                    <div class="absolute -top-16 -right-16 w-40 h-40 rounded-full blur-[80px] opacity-20 pointer-events-none" style="background: {{ $accent['border'] }}"></div>

                    {{-- رأس الكرت --}}
                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center border border-white/[0.08] shadow-inner" style="background: {{ $accent['bg'] }}">
                                @if($category->icon)
                                <img src="{{ $category->icon }}" class="w-5 h-5" alt="{{ $category->name }}">
                                @else
                                <i class="fa-solid fa-code text-sm" style="color: {{ $accent['border'] }}"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-[15px] text-white leading-tight snippet-title">{{ $snippet->title }}</h3>
                                <span class="text-[11px] text-gray-500 font-code">{{ $category->name }}</span>
                            </div>
                        </div>

                        {{-- Badge اللغة + زر النسخ --}}
                        <div class="flex items-center gap-2">
                            <span class="lang-badge px-2 py-1 rounded-md border border-white/[0.06]" style="background: {{ $accent['bg'] }}; color: {{ $accent['border'] }}">
                                {{ $snippet->language }}
                            </span>
                            <button onclick="copyCode(this, '{{ base64_encode($snippet->code) }}')"
                                class="copy-btn w-8 h-8 rounded-lg bg-white/[0.04] border border-white/[0.08] flex items-center justify-center text-gray-400 hover:text-blue-400">
                                <span class="tooltip">نسخ الكود</span>
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                    </div>

                    {{-- الوصف --}}
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed snippet-desc">{{ $snippet->description }}</p>

                    {{-- منطقة الكود --}}
                    <div class="mt-auto code-block">
                        <div class="editor-dots">
                            <span class="editor-dot" style="background: #ff5f56;"></span>
                            <span class="editor-dot" style="background: #ffbd2e;"></span>
                            <span class="editor-dot" style="background: #27c93f;"></span>
                            <span class="mr-auto text-[10px] text-gray-600 font-code flex items-center gap-1">
                                <i class="fa-regular fa-file-code text-[9px]"></i>
                                main.{{ $snippet->language === 'javascript' ? 'js' : $snippet->language }}
                            </span>
                        </div>
                        <div class="overflow-x-auto max-h-48">
                            <pre class="line-numbers"><code class="language-{{ $snippet->language }}">{{ $snippet->code }}</code></pre>
                        </div>
                    </div>
                </div>

                @endforeach
                @endforeach
            </div>
        </section>
        @endforeach

        {{-- رسالة لا توجد نتائج --}}
        <div id="noResults" class="hidden text-center py-24">
            <div class="w-20 h-20 rounded-full bg-white/[0.03] border border-white/[0.06] flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-ghost text-4xl text-gray-700 animate-bounce"></i>
            </div>
            <p class="text-gray-500 font-code text-lg mb-2">لا توجد نتائج</p>
            <p class="text-gray-600 text-sm">جرب كلمة بحث مختلفة...</p>
        </div>

    </main>

    {{-- ════════════════════════════════════════════════════════════════
         الفوتر
    ════════════════════════════════════════════════════════════════ --}}
    <footer class="relative z-10 border-t border-white/[0.04] mt-10">
        <div class="max-w-7xl mx-auto px-6 py-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-md bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-code text-white text-[10px]"></i>
                    </div>
                    <span class="text-sm text-gray-500">
                        SNIP_MANAGER &copy; {{ date('Y') }}
                    </span>
                </div>
                <div class="flex items-center gap-3 text-gray-600 text-xs font-code">
                    <span class="flex items-center gap-1"><i class="fa-brands fa-laravel text-red-400"></i> Laravel</span>
                    <span class="text-gray-700">•</span>
                    <span class="flex items-center gap-1"><i class="fa-brands fa-php text-indigo-400"></i> PHP</span>
                    <span class="text-gray-700">•</span>
                    <span class="flex items-center gap-1"><i class="fa-brands fa-css3-alt text-blue-400"></i> Tailwind</span>
                </div>
            </div>
        </div>
    </footer>


    {{-- ════════════════════════════════════════════════════════════════
         JavaScript
    ════════════════════════════════════════════════════════════════ --}}
    <script>
        // ═══════ 1. Particles Background ═══════
        (function() {
            const canvas = document.getElementById('particles-canvas');
            const ctx = canvas.getContext('2d');
            let particles = [];
            const PARTICLE_COUNT = 60;

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            class Particle {
                constructor() {
                    this.reset();
                }
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 1.5 + 0.5;
                    this.speedX = (Math.random() - 0.5) * 0.3;
                    this.speedY = (Math.random() - 0.5) * 0.3;
                    this.opacity = Math.random() * 0.3 + 0.1;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(148, 163, 184, ${this.opacity})`;
                    ctx.fill();
                }
            }

            for (let i = 0; i < PARTICLE_COUNT; i++) {
                particles.push(new Particle());
            }

            function connectParticles() {
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 120) {
                            ctx.beginPath();
                            ctx.strokeStyle = `rgba(100, 116, 139, ${0.06 * (1 - dist / 120)})`;
                            ctx.lineWidth = 0.5;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                connectParticles();
                requestAnimationFrame(animate);
            }
            animate();
        })();

        // ═══════ 2. Navbar Scroll Effect ═══════
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ═══════ 3. Reveal Animation (Intersection Observer) ═══════
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ═══════ 4. البحث الفوري ═══════
        const searchInput = document.getElementById('searchInput');
        const snippetCards = document.querySelectorAll('.snippet-card');
        const noResults = document.getElementById('noResults');
        const categorySections = document.querySelectorAll('.category-section');

        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase().trim();
            let hasResults = false;

            snippetCards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const desc = card.dataset.desc.toLowerCase();
                const lang = card.dataset.lang.toLowerCase();
                const match = !term || title.includes(term) || desc.includes(term) || lang.includes(term);
                card.style.display = match ? '' : 'none';
                if (match) hasResults = true;
            });

            categorySections.forEach(section => {
                const visibles = section.querySelectorAll('.snippet-card:not([style*="display: none"])');
                section.style.display = visibles.length === 0 ? 'none' : '';
            });

            noResults.classList.toggle('hidden', hasResults || !term);
        });

        // ═══════ 5. فلاتر الأقسام ═══════
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;
                let hasResults = false;

                categorySections.forEach(section => {
                    if (filter === 'all' || section.dataset.type === filter) {
                        section.style.display = '';
                        hasResults = true;
                    } else {
                        section.style.display = 'none';
                    }
                });

                noResults.classList.toggle('hidden', hasResults);

                // إعادة تشغيل البحث مع الفلتر
                searchInput.value = '';
            });
        });

        // ═══════ 6. النسخ ═══════
        function copyCode(btn, base64Code) {
            const code = decodeURIComponent(escape(atob(base64Code)));
            navigator.clipboard.writeText(code).then(() => {
                const icon = btn.querySelector('i');
                const originalClass = icon.className;

                icon.className = 'fa-solid fa-check text-xs';
                btn.style.background = 'rgba(16, 185, 129, 0.15)';
                btn.style.borderColor = 'rgba(16, 185, 129, 0.4)';
                btn.style.color = '#10b981';

                // تحديث الـ tooltip
                const tooltip = btn.querySelector('.tooltip');
                if (tooltip) tooltip.textContent = 'تم النسخ ✓';

                setTimeout(() => {
                    icon.className = originalClass;
                    btn.style.background = '';
                    btn.style.borderColor = '';
                    btn.style.color = '';
                    if (tooltip) tooltip.textContent = 'نسخ الكود';
                }, 2000);
            });
        }

        // ═══════ 7. اختصار لوحة المفاتيح للبحث ═══════
        document.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement !== searchInput) {
                e.preventDefault();
                searchInput.focus();
            }
            if (e.key === 'Escape') {
                searchInput.blur();
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        });

        // ═══════ 8. Prism.js highlight ═══════
        document.addEventListener('DOMContentLoaded', () => {
            Prism.highlightAll();
        });
    </script>
</body>

</html>