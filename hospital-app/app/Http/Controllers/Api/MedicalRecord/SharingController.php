<?php

namespace App\Http\Controllers\Api\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecordResource;
use App\Models\MedicalRecord;
use App\Traits\HttpResponses;
use App\Traits\LogsMedicalAccess;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SharingController extends Controller
{
    // traits
    use HttpResponses, LogsMedicalAccess;

    // 
    public function createToken(MedicalRecord $record)
    {
        $this->authorize('view', $record); // Only the patient (or the doctor)

        // Only patient can share their own record
        if (auth()->id() !== $record->patient_id) {
            return $this->error('Only the patient can share their medical record.', 403);
        }

        // generate token
        $token = Str::random(64);
        // Save token in cache for 24 hours
        Cache::put("share_token_{$token}", $record->id, now()->addHours(24));

        // return share link
        return $this->success([
            'share_link' => url("/api/shared/view/{$token}"),
            'expires_at' => now()->addHours(24)
        ], 'Secure share link created (valid for 24 hours)');
    }

    public function viewShared($token)
    {
        $recordId = Cache::get("share_token_{$token}");

        if (!$recordId) {
            return $this->error('Invalid or expired share link', 404);
        }

        $record = MedicalRecord::with(['doctor', 'attachments', 'patient'])->find($recordId);

        if (!$record) {
            return $this->error('Record not found', 404);
        }

        // Log access (anonymous or system user)
        $this->logAccess($record->id, 'view_shared', $record->patient_id);

        return $this->success(new MedicalRecordResource($record), 'Shared Medical Record');
    }
}
