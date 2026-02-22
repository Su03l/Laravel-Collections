<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\UpdateProfileRequest;
use App\Http\Resources\PatientProfileResource;
use App\Mail\SecurityAlertMail;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Mail;

class UpdateProfileController extends Controller
{
    use HttpResponses;

    public function __invoke(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $profile = $user->patientProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'blood_type' => $request->blood_type,
                'chronic_diseases' => $request->chronic_diseases,
                'allergies' => $request->allergies,
                'past_surgeries' => $request->past_surgeries,
            ]
        );

        // إرسال تنبيه أمني بتحديث الملف الطبي
        Mail::to($user->email)->send(new SecurityAlertMail($user, 'profile_updated', [
            'ip' => $request->ip(),
            'device' => $request->userAgent(),
            'time' => now()->toDateTimeString(),
        ]));

        return $this->success(new PatientProfileResource($profile), 'تم تحديث ملفك الطبي بنجاح');
    }
}
