<?php

use Illuminate\Support\Facades\Route;
use Modules\Corporative\Http\Controllers\CorporativeController;

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

Route::group(['prefix' =>"admin", 'middleware' => 'auth'], function () {
    Route::resource('corporative', CorporativeController::class)->names('corporative');
    Route::get('/corporative/changeStatusFalse/{id}', [CorporativeController::class, 'changeStatusFalse'])->name('corporative.changeStatusFalse');
    Route::get('/corporative/changeStatusTrue/{id}', [CorporativeController::class, 'changeStatusTrue'])->name('corporative.changeStatusTrue');
    Route::get('/corporative/deleteFile/{id}', [CorporativeController::class, 'deleteFile'])->name('corporative.deleteFile');
});
