<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

// welcome page
Route::get('/', function () {
    return view('welcome');
});

Route::resource('notes', NoteController::class);
