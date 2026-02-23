<?php

use App\Http\Middleware\Check2FA;
use App\Http\Middleware\IsAdmin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            '2fa' => Check2FA::class,
            'admin' => IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                // معالجة خطأ عدم وجود السجل (404)
                if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                    return response()->json([
                        'status' => 'Error',
                        'message' => 'السجل المطلوب غير موجود',
                    ], 404);
                }

                // معالجة باقي الأخطاء (500)
                return response()->json([
                    'status' => 'Error',
                    'message' => 'حدث خطأ في النظام: ' . $e->getMessage(),
                    'code' => $e->getCode() ?: 500
                ], 500);
            }
        });
    })->create();
