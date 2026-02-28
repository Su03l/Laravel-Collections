<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Review;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // traits
    use HttpResponses;

    public function store(Request $request, Appointment $appointment)
    {
        // Check if the appointment is completed and belongs to the user
        if ($appointment->status !== 'completed' || $appointment->patient_id !== auth()->id()) {
            return $this->error(null, 'You can only review completed appointments that belong to you.', 403);
        }

        // Check if already reviewed (handled by unique constraint in DB, but good to check here too)
        if (Review::where('appointment_id', $appointment->id)->exists()) {
            return $this->error(null, 'You have already reviewed this appointment.', 409);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check validation
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // Create review
        $review = Review::create([
            'appointment_id' => $appointment->id,
            'patient_id' => auth()->id(),
            'doctor_id' => $appointment->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return $this->success($review, 'Thank you for your review!');
    }
}
