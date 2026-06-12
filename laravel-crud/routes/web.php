<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CultureController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('cultures', CultureController::class)->middleware(['auth']);
Route::resource('users', UserController::class)->middleware(['auth']);

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';