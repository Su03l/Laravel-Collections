<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // إذا كان مسجل دخول وصلاحيته admin، خله يمر
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // غير كذا، اطرده لصفحة 403 (غير مصرح)
        abort(403, 'عذراً، هذه الصفحة مخصصة لمديري النظام فقط.');
    }
}
