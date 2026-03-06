<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SnippetController;

// 
Route::get('/', [SnippetController::class, 'index']);
