<?php

use Illuminate\Support\Facades\Route;
use Modules\TrainingCategory\Http\Controllers\TrainingCategoryController;

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
    Route::resource('trainingcategory', TrainingCategoryController::class)->names('trainingcategory');
    Route::get('/trainingcategory/changeStatusFalse/{id}', [TrainingCategoryController::class, 'changeStatusFalse'])->name('trainingcategory.changeStatusFalse');
    Route::get('/trainingcategory/changeStatusTrue/{id}', [TrainingCategoryController::class, 'changeStatusTrue'])->name('trainingcategory.changeStatusTrue');
});
