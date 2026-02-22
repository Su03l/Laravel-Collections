<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use HttpResponses;

    // this for store /api/logout
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(null, 'تم تسجيل الخروج بنجاح');
    }
}
