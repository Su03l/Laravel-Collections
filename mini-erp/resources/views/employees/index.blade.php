<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP | وحدة التحكم المركزية</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@400;700;800&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #050505;
            color: #ffffff;
            font-family: 'Changa', sans-serif;
        }
        .mono { font-family: 'Space Mono', monospace; }

        /* تأثيرات الوحشية الرقمية (Brutalism) */
        .brutal-border { border: 2px solid #ffffff; }
        .brutal-shadow { box-shadow: 6px 6px 0px #ffffff; transition: all 0.15s ease-out; }
        .brutal-shadow:hover { box-shadow: 2px 2px 0px #ffffff; transform: translate(4px, 4px); }

        .brutal-shadow-red { box-shadow: 6px 6px 0px #ff2a2a; border-color: #ff2a2a; color: #ff2a2a; }
        .brutal-shadow-red:hover { box-shadow: 2px 2px 0px #ff2a2a; transform: translate(4px, 4px); background-color: #ff2a2a; color: #000; }

        /* تخصيص الجدول */
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 1rem; text-align: right; }
        th { background-color: #111; text-transform: uppercase; letter-spacing: 0.1em; }
        tr:hover { background-color: #1a1a1a; }
    </style>
</head>
<body class="min-h-screen p-8 selection:bg-white selection:text-black">

    <div class="max-w-7xl mx-auto">

        <header class="mb-12 flex flex-col md:flex-row justify-between items-end border-b-4 border-white pb-6">
            <div>
                <span class="mono text-xs text-gray-500 tracking-widest uppercase mb-2 block">SYSTEM_ACCESS // GRANTED</span>
                <h1 class="text-5xl font-extrabold uppercase tracking-tight">قاعدة بيانات <br> <span class="text-gray-400">الموظفين.</span></h1>
            </div>

            <div class="mt-6 md:mt-0">
                <a href="{{ route('employees.create') }}" class="inline-block brutal-border brutal-shadow bg-black text-white px-8 py-3 font-bold uppercase tracking-widest text-sm mono">
                    + تسجيل موظف جديد
                </a>
            </div>
        </header>

        @if(session('success'))
            <div class="brutal-border bg-white text-black p-4 mb-8 font-bold flex justify-between items-center animate-pulse">
                <span>[ إشعار نظام ] : {{ session('success') }}</span>
                <span class="mono text-xs uppercase">Action_Completed</span>
            </div>
        @endif

        <main class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="mono text-xs text-gray-400">
                        <th>المعرف [ID]</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>القسم</th>
                        <th>الراتب</th>
                        <th>الصلاحية</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="mono">
                    @forelse($employees as $employee)
                        <tr>
                            <td class="text-gray-500">#{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="font-bold text-white font-sans text-base">{{ $employee->name }}</td>
                            <td class="text-gray-400">{{ $employee->email }}</td>

                            <td>
                                @if($employee->department)
                                    <span class="border border-gray-600 px-2 py-1 text-xs">{{ $employee->department->name }}</span>
                                @else
                                    <span class="text-red-500 text-xs">غير محدد</span>
                                @endif
                            </td>

                            <td>{{ number_format($employee->salary) }} SAR</td>

                            <td>
                                @if($employee->role === 'admin')
                                    <span class="bg-white text-black px-2 py-1 text-xs font-bold">ADMIN</span>
                                @else
                                    <span class="border border-gray-600 px-2 py-1 text-xs text-gray-400">USER</span>
                                @endif
                            </td>

                            <td class="flex gap-3">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="text-white hover:bg-white hover:text-black border border-white px-3 py-1 text-xs transition-colors">
                                    تعديل
                                </a>

                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('تأكيد مسح بيانات الموظف من النظام؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 border border-red-500 px-3 py-1 text-xs hover:bg-red-500 hover:text-black transition-colors">
                                        إلغاء تنشيط
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500 text-lg font-sans">
                                [ قاعدة البيانات فارغة. لا يوجد موظفين مسجلين حالياً. ]
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </main>

    </div>

</body>
</html>
