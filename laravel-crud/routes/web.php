<?php

use App\Http\Controllers\CultureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cultures', CultureController::class);
