<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // 
    public function index()
    {
        // نستخدم with('department') لمنع مشكلة N+1 في استعلامات الداتابيز
        $employees = User::where('role', 'employee')->with('department')->get();

        // نمرر البيانات لملف البليد اللي بنصممه لاحقاً
        return view('employees.index', compact('employees'));
    }

    //  عرض صفحة (فورم) إضافة موظف جديد
    public function create()
    {
        // نجيب كل الأقسام عشان نعرضها في قائمة منسدلة (Select) في الفورم
        $departments = Department::all();

        return view('employees.create', compact('departments'));
    }

    //  استلام بيانات الفورم وحفظ الموظف في الداتابيز
    public function store(Request $request)
    {
        // التحقق من صحة البيانات (Validation)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'department_id' => 'nullable|exists:departments,id',
            'salary' => 'nullable|numeric',
        ]);

        // تشفير الباسوورد وتجهيز البيانات الافتراضية
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'employee';
        $validated['join_date'] = now();
        $validated['is_active'] = true;

        // حفظ الموظف
        User::create($validated);

        // توجيه الأدمن لصفحة الموظفين مع رسالة نجاح
        return redirect()->route('employees.index')
            ->with('success', 'تم تسجيل الموظف في النظام بنجاح!');
    }

    //  عرض صفحة (فورم) تعديل بيانات موظف
    public function edit(User $employee)
    {
        $departments = Department::all();

        return view('employees.edit', compact('employee', 'departments'));
    }

    //  استلام التعديلات وحفظها
    public function update(Request $request, User $employee)
    {
        // التحقق من صحة البيانات (Validation)
        // ملاحظة: قمت بتعديل الكود هنا قليلاً لضمان أن المتغير $validated معرف
        $rules = [
            'name' => 'required|string|max:255',
            // استثناء إيميل الموظف الحالي من شرط عدم التكرار
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'department_id' => 'nullable|exists:departments,id',
            'salary' => 'nullable|numeric',
            'is_active' => 'boolean',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6';
        }

        $validated = $request->validate($rules);

        // إذا تم إدخال باسوورد جديد، نشفره ونحفظه
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            // إزالة الباسوورد من المصفوفة إذا لم يتم إرساله لتجنب تحديثه بقيمة فارغة أو null
            unset($validated['password']);
        }

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'تم تحديث بيانات الموظف بنجاح.');
    }

    
    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'تم حذف ملف الموظف نهائياً.');
    }
}
