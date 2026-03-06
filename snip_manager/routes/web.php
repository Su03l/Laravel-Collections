<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SnippetController;

//  the home page
Route::get('/', [SnippetController::class, 'index']);
