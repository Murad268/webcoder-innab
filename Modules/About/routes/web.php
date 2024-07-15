<?php

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\AboutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => "admin"], function () {
    Route::resource('about', AboutController::class)->names('about');
    Route::get('/about/changeStatusFalse/{id}', [AboutController::class, 'changeStatusFalse'])->name('about.changeStatusFalse');
    Route::get('/about/changeStatusTrue/{id}', [AboutController::class, 'changeStatusTrue'])->name('about.changeStatusTrue');
    Route::get('/about/deleteFile/{id}', [AboutController::class, 'deleteFile'])->name('about.deleteFile');
});
