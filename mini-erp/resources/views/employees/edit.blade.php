<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات الموظف | وحدة التحكم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@400;700;800&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { background-color: #050505; color: #ffffff; font-family: 'Changa', sans-serif; }
        .mono { font-family: 'Space Mono', monospace; }

        /* تأثيرات الـ Brutalism */
        .brutal-input {
            background-color: transparent; border: 2px solid #333; color: #fff;
            padding: 0.75rem 1rem; width: 100%; transition: all 0.2s ease; outline: none;
        }
        .brutal-input:focus { border-color: #fff; box-shadow: 4px 4px 0px #fff; transform: translate(-2px, -2px); }

        .brutal-btn {
            border: 2px solid #ffffff; background-color: #ffffff; color: #000;
            box-shadow: 6px 6px 0px #333; transition: all 0.15s ease-out; cursor: pointer;
        }
        .brutal-btn:hover { box-shadow: 2px 2px 0px #333; transform: translate(4px, 4px); background-color: #000; color: #fff; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 selection:bg-white selection:text-black">

    <div class="w-full max-w-2xl border-4 border-white p-8 md:p-12 relative bg-[#0a0a0a]">

        <div class="absolute top-0 right-0 w-8 h-8 bg-white"></div>

        <header class="mb-10 border-b-2 border-gray-800 pb-4">
            <span class="mono text-xs text-yellow-500 tracking-widest uppercase block mb-1">ACTION // UPDATE_RECORD [#{{ $employee->id }}]</span>
            <h2 class="text-4xl font-extrabold uppercase">تحديث <span class="text-gray-400">البيانات.</span></h2>
        </header>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mono text-xs uppercase tracking-widest text-gray-400 mb-2">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="brutal-input font-sans text-lg" required>
                </div>

                <div>
                    <label class="block mono text-xs uppercase tracking-widest text-gray-400 mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="brutal-input mono text-sm" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mono text-xs uppercase tracking-widest text-gray-400 mb-2">تغيير الرقم السري (اختياري)</label>
                    <input type="password" name="password" class="brutal-input mono" placeholder="اتركه فارغاً إذا لم ترد تغييره">
                </div>

                <div>
                    <label class="block mono text-xs uppercase tracking-widest text-gray-400 mb-2">الراتب (SAR)</label>
                    <input type="number" name="salary" value="{{ old('salary', $employee->salary) }}" class="brutal-input mono">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                <div>
                    <label class="block mono text-xs uppercase tracking-widest text-gray-400 mb-2">القسم</label>
                    <select name="department_id" class="brutal-input font-sans appearance-none rounded-none bg-[#0a0a0a]">
                        <option value="">[ بدون قسم ]</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ (old('department_id', $employee->department_id) == $department->id) ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mono text-xs uppercase tracking-widest text-gray-400 mb-2">حالة الحساب</label>
                    <select name="is_active" class="brutal-input font-sans appearance-none rounded-none bg-[#0a0a0a]">
                        <option value="1" {{ old('is_active', $employee->is_active) ? 'selected' : '' }}>نشط (Active)</option>
                        <option value="0" {{ !old('is_active', $employee->is_active) ? 'selected' : '' }}>موقوف (Suspended)</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 pt-6 border-t-2 border-gray-800 mt-8">
                <button type="submit" class="brutal-btn flex-1 py-4 font-bold uppercase tracking-widest text-sm mono">
                    [ حفظ التعديلات ]
                </button>
                <a href="{{ route('employees.index') }}" class="border-2 border-gray-600 text-gray-400 text-center py-4 px-8 hover:bg-gray-800 transition-colors uppercase font-bold mono text-sm">
                    إلغاء
                </a>
            </div>
        </form>

    </div>

</body>
</html>
