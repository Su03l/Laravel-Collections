<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات الموظف | ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Sans Arabic', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-black antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Sidebar -->
        <aside class="w-full md:w-72 bg-white border-l-0 md:border-l border-b md:border-b-0 border-gray-200 flex flex-col justify-between md:h-screen sticky top-0 z-20 shadow-sm">
            <div>
                <div class="h-20 flex items-center px-8 border-b border-gray-100">
                    <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center text-white font-bold text-lg ml-3">E</div>
                    <h1 class="text-xl font-bold tracking-tight">MINI_ERP</h1>
                </div>

                <nav class="p-6 space-y-1">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">القائمة الرئيسية</p>

                    <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gray-50 text-black font-medium rounded-lg transition-all hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>الموظفين</span>
                    </a>
                </nav>
            </div>

            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <div class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-black font-bold text-sm shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="font-bold text-sm truncate text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">admin@erp.com</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 border border-gray-300 py-2.5 rounded-lg text-xs font-bold text-gray-700 hover:bg-black hover:text-white hover:border-black transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        تسجيل خروج
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto h-screen bg-gray-50">
            <!-- Top Header -->
            <header class="h-20 border-b border-gray-200 bg-white flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
                <div class="flex items-center gap-4">
                    <h2 class="text-xl font-bold text-gray-800">تعديل بيانات الموظف</h2>
                </div>
                <a href="{{ route('employees.index') }}" class="text-sm text-gray-500 hover:text-black flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    عودة للقائمة
                </a>
            </header>

            <div class="p-6 md:p-10 max-w-4xl mx-auto">

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">تحديث السجل #{{ $employee->id }}</h3>
                            <p class="text-sm text-gray-500 mt-1">تعديل بيانات الموظف: {{ $employee->name }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold">
                            {{ substr($employee->name, 0, 1) }}
                        </div>
                    </div>

                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="p-6 md:p-8 space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition-all outline-none" required>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition-all outline-none" required>
                                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور (اختياري)</label>
                                <input type="password" name="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition-all outline-none" placeholder="اتركه فارغاً إذا لم ترد تغييره">
                                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">الراتب الشهري (SAR)</label>
                                <input type="number" name="salary" value="{{ old('salary', $employee->salary) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition-all outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">القسم</label>
                                <div class="relative">
                                    <select name="department_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition-all outline-none appearance-none">
                                        <option value="">-- اختر القسم --</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">حالة الحساب</label>
                                <div class="relative">
                                    <select name="is_active" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition-all outline-none appearance-none">
                                        <option value="1" {{ old('is_active', $employee->is_active) ? 'selected' : '' }}>نشط (Active)</option>
                                        <option value="0" {{ !old('is_active', $employee->is_active) ? 'selected' : '' }}>موقوف (Suspended)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-6">
                            <a href="{{ route('employees.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">إلغاء</a>
                            <button type="submit" class="px-8 py-2.5 bg-black text-white rounded-lg font-medium hover:bg-gray-800 transition-colors shadow-lg flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                تحديث البيانات
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

</body>
</html>
