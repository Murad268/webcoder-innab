<?php

use Illuminate\Support\Facades\Route;
use Modules\Training\Http\Controllers\TrainingController;

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
    Route::resource('training', TrainingController::class)->names('training');
    Route::get('/training/changeStatusFalse/{id}', [TrainingController::class, 'changeStatusFalse'])->name('training.changeStatusFalse');
    Route::get('/training/changeStatusTrue/{id}', [TrainingController::class, 'changeStatusTrue'])->name('training.changeStatusTrue');
    Route::get('/training/deleteFile/{id}', [TrainingController::class, 'deleteFile'])->name('training.deleteFile');
});
