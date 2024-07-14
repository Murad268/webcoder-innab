<?php

use Illuminate\Support\Facades\Route;
use Modules\Vebinar\Http\Controllers\VebinarController;

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
    Route::resource('vebinar', VebinarController::class)->names('vebinar');
    Route::get('/vebinar/changeStatusFalse/{id}', [VebinarController::class, 'changeStatusFalse'])->name('vebinar.changeStatusFalse');
    Route::get('/vebinar/changeStatusTrue/{id}', [VebinarController::class, 'changeStatusTrue'])->name('vebinar.changeStatusTrue');
    Route::get('/vebinar/deleteFile/{id}', [VebinarController::class, 'deleteFile'])->name('vebinar.deleteFile');
});
