<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'blood_type' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'chronic_diseases' => 'nullable|string',
            'allergies' => 'nullable|string',
            'past_surgeries' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'Error',
            'message' => 'أخطاء في المدخلات',
            'data' => $validator->errors()
        ], 422));
    }
}
