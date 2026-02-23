<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{

    // the middleware handler for the route
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'غير مصرح لك، هذه المنطقة للأدمن فقط'], 403);
    }
}
