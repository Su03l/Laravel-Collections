<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SnippetController;

// الصفحة الرئيسية للمجرة 🌌
Route::get('/', [SnippetController::class, 'index']);
