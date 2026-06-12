<?php

use Illuminate\Support\Facades\Route;

// Redirect de homepagina naar het dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Je dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Laad de Breeze routes
require __DIR__.'/auth.php';
require __DIR__.'/profile.php'; // <--- DIT IS DE REGEL DIE JE NODIG HAD