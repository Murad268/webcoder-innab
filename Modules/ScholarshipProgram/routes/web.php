<?php

use Illuminate\Support\Facades\Route;
use Modules\ScholarshipProgram\Http\Controllers\ScholarshipProgramController;

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
    Route::resource('scholarshipprogram', ScholarshipProgramController::class)->names('scholarshipprogram');
    Route::get('/scholarshipprogram/changeStatusFalse/{id}', [ScholarshipProgramController::class, 'changeStatusFalse'])->name('scholarshipprogram.changeStatusFalse');
    Route::get('/scholarshipprogram/changeStatusTrue/{id}', [ScholarshipProgramController::class, 'changeStatusTrue'])->name('scholarshipprogram.changeStatusTrue');
    Route::get('/scholarshipprogram/deleteFile/{id}', [ScholarshipProgramController::class, 'deleteFile'])->name('scholarshipprogram.deleteFile');
});
