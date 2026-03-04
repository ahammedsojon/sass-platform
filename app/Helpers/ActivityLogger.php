<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log($user, $action, $model, $description = null)
    {
        if (!$user) return;

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'model_type' => class_basename($model),
            'model_id' => $model->id,
            'description' => $description
        ]);
    }
}
