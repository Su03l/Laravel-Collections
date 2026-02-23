<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadImage($file, $folder, $oldFile = null)
    {
        // إذا فيه صورة قديمة، احذفها من السيرفر فوراً
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        return $file->store($folder, 'public');
    }
}
