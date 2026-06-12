<?php

use App\Http\Controllers\CultureController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// CRUD routes voor de culturen (Game Data)
Route::resource('cultures', CultureController::class);

// CRUD routes voor de accounts (User Management)
Route::resource('users', UserController::class);