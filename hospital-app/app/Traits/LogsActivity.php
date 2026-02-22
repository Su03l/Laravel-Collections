<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::updated(function ($model) {
            Log::info("تم تحديث الموديل " . class_basename($model) . " بالمعرف " . $model->id);
        });

        static::created(function ($model) {
            Log::info("تم إنشاء موديل جديد " . class_basename($model) . " بالمعرف " . $model->id);
        });

        static::deleted(function ($model) {
            Log::info("تم حذف الموديل " . class_basename($model) . " بالمعرف " . $model->id);
        });
    }
}
