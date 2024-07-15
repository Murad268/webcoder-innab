<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\VacancyController;

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
    Route::resource('vacancy', VacancyController::class)->names('vacancy');
    Route::get('/vacancy/changeStatusFalse/{id}', [VacancyController::class, 'changeStatusFalse'])->name('vacancy.changeStatusFalse');
    Route::get('/vacancy/changeStatusTrue/{id}', [VacancyController::class, 'changeStatusTrue'])->name('vacancy.changeStatusTrue');
    Route::get('/vacancy/deleteFile/{id}', [VacancyController::class, 'deleteFile'])->name('vacancy.deleteFile');
});
