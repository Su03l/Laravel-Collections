<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    use HttpResponses;

    // this for store /api/two-factor
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->update([
            'two_factor_enabled' => !$user->two_factor_enabled
        ]);

        return $this->success(['two_factor_enabled' => $user->two_factor_enabled], 'تم تحديث إعدادات التحقق الثنائي');
    }
}
