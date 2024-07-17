<?php

use Illuminate\Support\Facades\Route;
use Modules\Workshop\Http\Controllers\WorkshopController;

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

Route::group(['prefix' => "admin", 'middleware' => 'auth'], function () {
    Route::resource('workshop', WorkshopController::class)->names('workshop');
    Route::get('/workshop/changeStatusFalse/{id}', [WorkshopController::class, 'changeStatusFalse'])->name('workshop.changeStatusFalse');
    Route::get('/workshop/changeStatusTrue/{id}', [WorkshopController::class, 'changeStatusTrue'])->name('workshop.changeStatusTrue');
    Route::get('/workshop/deleteFile/{id}', [WorkshopController::class, 'deleteFile'])->name('workshop.deleteFile');
});
