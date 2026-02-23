<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    // uploade image to server
    public function uploadImage($file, $folder, $oldFile = null)
    {
        // check if the file exists
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        return $file->store($folder, 'public');
    }
}
