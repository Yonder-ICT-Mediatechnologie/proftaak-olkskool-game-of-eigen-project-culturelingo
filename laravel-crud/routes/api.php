<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CultureController;

Route::get('/cultures', [CultureController::class, 'apiIndex']);