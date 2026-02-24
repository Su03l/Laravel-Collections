<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    // show all doctors
    public function index(Request $request)
    {
        // get
        $query = Doctor::with(['hospital', 'clinic']);

        if ($request->has('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        if ($request->has('clinic_id')) {
            $query->where('clinic_id', $request->clinic_id);
        }

        $doctors = $query->where('is_active', true)->paginate(10);

        return $this->success(DoctorResource::collection($doctors), 'قائمة الدكاترة جاهزة');
    }

    // show doctor details
    public function show(Doctor $doctor)
    {
        $doctor->load(['hospital', 'clinic', 'schedules']);
        return $this->success(new DoctorResource($doctor), 'تفاصيل الدكتور جاهزة');
    }

    // show available slots for a doctor on a specific date
    public function availableSlots(Request $request, Doctor $doctor)
    {
        // validate request data
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today',
        ]);

        // if validation fails return error
        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        //
        $dayName = date('l', strtotime($request->date));
        $schedule = $doctor->schedules()->where('day_of_week', $dayName)->first();

        if (!$schedule) {
            return $this->success([], 'الدكتور لا يعمل في هذا اليوم');
        }

        return $this->success([
            'working_hours' => [
                'start' => $schedule->start_time,
                'end' => $schedule->end_time,
            ],
            'date' => $request->date
        ], 'أوقات دوام الدكتور في هذا التاريخ');
    }
}
