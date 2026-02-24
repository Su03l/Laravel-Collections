<?php

use Illuminate\Support\Facades\Route;

// for welcome page
Route::get('/', function () {
    return view('welcome');
});
