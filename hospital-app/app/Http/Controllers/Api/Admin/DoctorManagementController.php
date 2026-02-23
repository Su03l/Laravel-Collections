<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorManagementController extends Controller
{
    // show all doctors from admin
    public function dashboardStats()
    {
        $stats = [
            'total_patients' => User::where('role', 'patient')->count(),
            'total_doctors' => User::where('role', 'doctor')->count(),
            'total_hospitals' => Hospital::count(),
            // مستقبلاً نضيف عدد المواعيد المحجوزة لليوم
        ];

        return $this->success($stats, 'إحصائيات النظام');
    }

    // store doctor data from admin
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'hospital_id' => 'required|exists:hospitals,id',
            'clinic_id' => 'required|exists:clinics,id',
            'specialization' => 'required|string',
            'experience_years' => 'required|integer',
            'bio' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        // 1. إنشاء حساب مستخدم للدكتور
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? '05' . rand(10000000, 99999999), // رقم مؤقت إذا لم يرسل
            'password' => Hash::make('Doctor@123'), // باسورد مؤقت
            'role' => 'doctor',
            'email_verified_at' => now(),
        ]);

        // 2. ربط حساب المستخدم ببيانات الدكتور الطبية
        $doctor = Doctor::create([
            'id' => $user->id, // نستخدم نفس الـ UUID للربط
            'hospital_id' => $request->hospital_id,
            'clinic_id' => $request->clinic_id,
            'name' => $request->name,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'bio' => $request->bio,
            'is_active' => true,
        ]);

        return $this->success($doctor, 'تم إضافة الدكتور وتعيينه بنجاح');
    }

    // update doctor data from admin
    public function updateSchedule(Request $request, $doctorId)
    {
        $validator = Validator::make($request->all(), [
            'schedules' => 'required|array|min:1',
            'schedules.*.day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'schedules.*.start' => 'required|date_format:H:i',
            'schedules.*.end' => 'required|date_format:H:i|after:schedules.*.start',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $doctor = Doctor::findOrFail($doctorId);

        // حذف القديم وإضافة الجديد (Atomic Transaction)
        DB::transaction(function () use ($doctor, $request) {
            $doctor->schedules()->delete();
            foreach ($request->schedules as $slot) {
                $doctor->schedules()->create([
                    'day_of_week' => $slot['day'],
                    'start_time' => $slot['start'],
                    'end_time' => $slot['end'],
                ]);
            }
        });

        return $this->success(null, 'تم تحديث جدول دوام الدكتور بنجاح');
    }
}
