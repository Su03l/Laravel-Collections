<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

// welcome page
Route::get('/', function () {
    return view('welcome');
});

// notes routes
Route::resource('notes', NoteController::class);
