<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index']);
