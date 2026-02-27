<?php

namespace App\Traits;

use App\Models\MedicalAccessLog;

trait LogsMedicalAccess
{
    protected function logAccess($recordId, $action = 'view', $userId = null)
    {
        MedicalAccessLog::create([
            'user_id' => $userId ?? auth()->id(),
            'medical_record_id' => $recordId,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
