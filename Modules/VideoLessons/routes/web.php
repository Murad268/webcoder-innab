<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessons\Http\Controllers\VideoLessonsController;

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
    Route::resource('videolessons', VideoLessonsController::class)->names('videolessons');
    Route::get('/videolessons/changeStatusFalse/{id}', [VideoLessonsController::class, 'changeStatusFalse'])->name('videolessons.changeStatusFalse');
    Route::get('/videolessons/changeStatusTrue/{id}', [VideoLessonsController::class, 'changeStatusTrue'])->name('videolessons.changeStatusTrue');
    Route::get('/videolessons/deleteFile/{id}', [VideoLessonsController::class, 'deleteFile'])->name('videolessons.deleteFile');
});
