<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Setting;
use App\Notifications\NewAppointmentNotification;
use App\Services\AppointmentService;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    // to use the 1 resourse requiestr
    use HttpResponses;

    // protected
    protected $appointmentService;

    // this for
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    // get the available slots for a doctor
    public function getAvailableSlots(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        // check for validation errors
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // find the doctor
        $doctor = Doctor::find($request->doctor_id);
        $slots = $this->appointmentService->generateAvailableSlots($doctor, $request->date);

        return $this->success($slots);
    }

    // book an appointment
    public function book(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'date'      => 'required|date|after_or_equal:today',
            'time'      => 'required|date_format:H:i',
        ]);

        // check for validation errors
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // 1. Prevent doctor from booking with themselves
        if (auth()->user()->role === 'doctor' && auth()->user()->doctorProfile && auth()->user()->doctorProfile->id === $request->doctor_id) {
            return $this->error('You cannot book an appointment with yourself!', 400);
        }

        // 2. Prevent patient from booking two appointments at the same time
        $hasConflict = Appointment::where('patient_id', auth()->id())
            ->where('appointment_date', $request->date)
            ->where('start_time', $request->time)
            ->where('status', 'confirmed')
            ->exists();

        // check if there is a conflict
        if ($hasConflict) {
            return $this->error('You already have another appointment at this time', 400);
        }

        // 3. Prevent double booking (Lock for Update)
        return DB::transaction(function () use ($request) {
            // Prevent double booking (Lock for Update)
            $exists = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->date)
                ->where('start_time', $request->time)
                ->lockForUpdate()
                ->exists();

            // check if the slot is booked
            if ($exists) {
                return $this->error('This slot has just been booked!', 409);
            }

            // Calculate end time based on settings
            $duration = Setting::where('key', 'appointment_duration')->value('value') ?? 15;
            $endTime = Carbon::parse($request->time)->addMinutes($duration)->format('H:i');

            $appointment = Appointment::create([
                'patient_id' => auth()->id(),
                'doctor_id' => $request->doctor_id,
                'appointment_date' => $request->date,
                'start_time' => $request->time,
                'end_time' => $endTime,
            ]);

            // Send Notification to Doctor
            $doctor = Doctor::find($request->doctor_id);
            if ($doctor && $doctor->user) {
                $doctor->user->notify(new NewAppointmentNotification($appointment));
            }

            return $this->success($appointment, 'Appointment booked successfully');
        });
    }

    // my appointments
    public function myAppointments()
    {
        // get the appointments
        $appointments = auth()->user()->appointments()
            ->with('doctor.hospital')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return $this->success($appointments);
    }

    // cancel an appointment
    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', auth()->id())
            ->first();

        // check for appointment
        if (!$appointment) {
            return $this->error('Appointment not found', 404);
        }

        // 1. Check appointment status
        if ($appointment->status !== 'confirmed') {
            return $this->error('Cannot cancel this appointment in its current status', 400);
        }

        // 2. Apply 2-hour cancellation policy
        $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->start_time);
        if (now()->diffInHours($appointmentDateTime, false) < 2) {
            return $this->error('Sorry, you cannot cancel less than 2 hours before the appointment', 400);
        }

        // 3. update the status
        $appointment->update(['status' => 'cancelled']);

        return $this->success(null, 'Appointment cancelled successfully');
    }


    // mark the patient as attended
    public function markAsAttended($id)
    {
        // find the patient appointment
        $appointment = Appointment::find($id);

        // check for appointment
        if (!$appointment) {
            return $this->error('Appointment not found', 404);
        }

        // Check if the user is a doctor and owns this appointment
        if (auth()->user()->role !== 'doctor' || !auth()->user()->doctorProfile || $appointment->doctor_id !== auth()->user()->doctorProfile->id) {
            return $this->error('Unauthorized to mark this patient as attended', 403);
        }

        // update the status
        $appointment->update(['status' => 'completed']);

        return $this->success(null, 'Patient marked as attended, you can now start the report');
    }

    // update the appointment
    public function update(Request $request, $id)
    {
        // find the appointment
        $appointment = Appointment::find($id);

        // check for appointment
        if (!$appointment) {
            return $this->error('Appointment not found', 404);
        }

        // 1. Check if the user is the owner of the appointment
        if ($appointment->patient_id !== auth()->id()) {
            return $this->error('Unauthorized to update this appointment', 403);
        }

        // validate the new date and time
        $validator = Validator::make($request->all(), [
            'new_date' => 'required|date|after_or_equal:today',
            'new_time' => 'required|date_format:H:i',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // 2. Re-run conflict check
        return DB::transaction(function () use ($request, $appointment) {
            $isSlotTaken = Appointment::where('doctor_id', $appointment->doctor_id)
                ->where('appointment_date', $request->new_date)
                ->where('start_time', $request->new_time)
                ->where('id', '!=', $appointment->id) // Exclude current appointment
                ->lockForUpdate()
                ->exists();

            // check if the slot is booked
            if ($isSlotTaken) {
                return $this->error('Sorry, the new slot is already booked', 409);
            }

            // Calculate new end time
            $duration = Setting::where('key', 'appointment_duration')->value('value') ?? 15;
            $endTime = Carbon::parse($request->new_time)->addMinutes($duration)->format('H:i');

            // 3. Update
            $appointment->update([
                'appointment_date' => $request->new_date,
                'start_time' => $request->new_time,
                'end_time' => $endTime,
                'status' => 'confirmed' // Re-confirm if it was cancelled
            ]);

            return $this->success($appointment, 'Appointment rescheduled successfully');
        });
    }
}
