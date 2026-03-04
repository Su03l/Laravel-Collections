<?php

use Illuminate\Support\Facades\Route;

// for welcome page
Route::get('/', function () {
    return view('welcome');
});

// Fallback for any other route not defined
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
