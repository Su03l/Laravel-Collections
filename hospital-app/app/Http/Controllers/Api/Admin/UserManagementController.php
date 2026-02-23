<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // toggle user status from admin
    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            return $this->error('لا يمكنك حظر أدمن آخر من هنا', 403);
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'تفعيل' : 'تعطيل';

        return $this->success(null, "تم {$status} الحساب بنجاح");
    }
}
