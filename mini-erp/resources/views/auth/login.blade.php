<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | النظام المركزي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@400;700;800&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { background-color: #050505; color: #ffffff; font-family: 'Changa', sans-serif; }
        .mono { font-family: 'Space Mono', monospace; }
        .brutal-input { background: transparent; border: 2px solid #333; color: #fff; padding: 1rem; width: 100%; outline: none; transition: 0.2s; }
        .brutal-input:focus { border-color: #fff; box-shadow: 4px 4px 0px #fff; transform: translate(-2px, -2px); }
        .brutal-btn { border: 2px solid #fff; background: #fff; color: #000; box-shadow: 6px 6px 0px #333; transition: 0.15s; cursor: pointer; }
        .brutal-btn:hover { box-shadow: 2px 2px 0px #333; transform: translate(4px, 4px); background: #000; color: #fff; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md border-4 border-white p-8 bg-[#0a0a0a] relative">
        <div class="absolute top-0 right-0 w-6 h-6 bg-white"></div>

        <header class="mb-8 border-b-2 border-gray-800 pb-4 text-center">
            <span class="mono text-xs text-red-500 tracking-widest uppercase block mb-2 animate-pulse">RESTRICTED_AREA //</span>
            <h2 class="text-3xl font-extrabold uppercase">تسجيل <span class="text-gray-400">الدخول</span></h2>
        </header>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            @if($errors->any())
                <div class="border border-red-500 text-red-500 p-3 text-sm mono text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block mono text-xs uppercase text-gray-400 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" class="brutal-input mono text-sm" required autofocus>
            </div>

            <div>
                <label class="block mono text-xs uppercase text-gray-400 mb-2">الرقم السري</label>
                <input type="password" name="password" class="brutal-input mono text-sm" required>
            </div>

            <button type="submit" class="brutal-btn w-full py-4 mt-4 font-bold uppercase tracking-widest text-sm mono">
                [ دخول النظام ]
            </button>
        </form>
    </div>

</body>
</html>
