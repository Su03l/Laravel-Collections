<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة الموظف | النظام المركزي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@400;700;800&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { background-color: #050505; color: #ffffff; font-family: 'Changa', sans-serif; }
        .mono { font-family: 'Space Mono', monospace; }

        .brutal-border { border: 2px solid #ffffff; }
        .brutal-shadow { box-shadow: 6px 6px 0px #333; transition: all 0.15s ease-out; }
        .brutal-shadow:hover { box-shadow: 2px 2px 0px #333; transform: translate(4px, 4px); }

        .data-box { border: 1px solid #333; padding: 1.5rem; background: #0a0a0a; }
    </style>
</head>
<body class="min-h-screen p-8 selection:bg-white selection:text-black flex flex-col items-center">

    <div class="w-full max-w-4xl">

        <header class="mb-12 flex flex-col md:flex-row justify-between items-end border-b-4 border-white pb-6">
            <div>
                <span class="mono text-xs text-green-500 tracking-widest uppercase mb-2 block animate-pulse">USER_NODE // ACTIVE</span>
                <h1 class="text-4xl font-extrabold uppercase tracking-tight">بوابة <br> <span class="text-gray-400">الموظف.</span></h1>
            </div>

            <div class="mt-6 md:mt-0 flex gap-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="brutal-border brutal-shadow bg-black text-white px-6 py-2 font-bold uppercase tracking-widest text-sm mono hover:bg-white hover:text-black transition-colors">
                        [ تسجيل الخروج ]
                    </button>
                </form>
            </div>
        </header>

        <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mono text-sm">

            <div class="data-box brutal-border">
                <span class="block text-gray-500 text-xs mb-2 uppercase">الاسم الكامل</span>
                <span class="text-xl font-sans font-bold text-white">{{ $user->name }}</span>
            </div>

            <div class="data-box brutal-border">
                <span class="block text-gray-500 text-xs mb-2 uppercase">المعرف الوظيفي [ID]</span>
                <span class="text-lg text-white">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="data-box brutal-border">
                <span class="block text-gray-500 text-xs mb-2 uppercase">البريد الإلكتروني</span>
                <span class="text-lg text-white">{{ $user->email }}</span>
            </div>

            <div class="data-box brutal-border">
                <span class="block text-gray-500 text-xs mb-2 uppercase">القسم الحالي</span>
                <span class="text-lg {{ $user->department ? 'text-white' : 'text-red-500' }}">
                    {{ $user->department ? $user->department->name : 'غير محدد' }}
                </span>
            </div>

            <div class="data-box brutal-border">
                <span class="block text-gray-500 text-xs mb-2 uppercase">الراتب الأساسي</span>
                <span class="text-lg text-white">{{ number_format($user->salary) }} SAR</span>
            </div>

            <div class="data-box brutal-border">
                <span class="block text-gray-500 text-xs mb-2 uppercase">تاريخ الانضمام</span>
                <span class="text-lg text-white">{{ $user->join_date ? $user->join_date->format('Y-m-d') : 'غير متوفر' }}</span>
            </div>

        </main>

    </div>

</body>
</html>
