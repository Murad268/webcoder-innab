<?php

use Illuminate\Support\Facades\Route;
use Modules\CourseFAQ\Http\Controllers\CourseFAQController;

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

Route::group(['prefix' =>'admin', 'middleware' => 'auth'], function () {
    Route::resource('coursefaq', CourseFAQController::class)->names('coursefaq');
    Route::get('/coursefaq/changeStatusFalse/{id}', [CourseFAQController::class, 'changeStatusFalse'])->name('coursefaq.changeStatusFalse');
    Route::get('/coursefaq/changeStatusTrue/{id}', [CourseFAQController::class, 'changeStatusTrue'])->name('coursefaq.changeStatusTrue');
    Route::get('/coursefaq/deleteFile/{id}', [CourseFAQController::class, 'deleteFile'])->name('coursefaq.deleteFile');
});
