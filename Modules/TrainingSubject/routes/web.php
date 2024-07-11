<?php

use Illuminate\Support\Facades\Route;
use Modules\TrainingSubject\Http\Controllers\TrainingSubjectController;

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

Route::group(['prefix' => 'admin'], function () {
    Route::resource('trainingsubject', TrainingSubjectController::class)->names('trainingsubject');
    Route::get('/trainingsubject/changeStatusFalse/{id}', [TrainingSubjectController::class, 'changeStatusFalse'])->name('trainingsubject.changeStatusFalse');
    Route::get('/trainingsubject/changeStatusTrue/{id}', [TrainingSubjectController::class, 'changeStatusTrue'])->name('trainingsubject.changeStatusTrue');
    Route::get('/trainingsubject/deleteFile/{id}', [TrainingSubjectController::class, 'deleteFile'])->name('trainingsubject.deleteFile');
});
