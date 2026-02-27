<?php

namespace App\Http\Controllers\Api\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Models\MedicalAttachment;
use App\Models\MedicalRecord;
use App\Traits\HttpResponses;
use App\Traits\LogsMedicalAccess;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    // traits for http responses and logging medical access
    use HttpResponses, LogsMedicalAccess;

    public function download(MedicalAttachment $attachment)
    {
        $this->authorize('view', $attachment->medicalRecord);

        $this->logAccess($attachment->medicalRecord->id, 'download_attachment');

        if (Storage::disk('private')->exists($attachment->file_path)) {
             return Storage::disk('private')->download($attachment->file_path, $attachment->file_name);
        }

        return $this->error('File not found', 404);
    }

    public function downloadPrescription(MedicalRecord $record) {
        // Check authorization (Patient or Doctor)
        $this->authorize('view', $record);

        $this->logAccess($record->id, 'download_pdf');

        // Generate PDF using DomPDF
        $pdf = Pdf::loadView('pdf.prescription', [
            'record' => $record,
            'hospital' => $record->doctor->hospital,
        ]);

        return $pdf->download("prescription_{$record->id}.pdf");
    }
}
