<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessonsTitle\Http\Controllers\VideoLessonsTitleController;

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
    Route::resource('videolessonstitle', VideoLessonsTitleController::class)->names('videolessonstitle');
    Route::get('/videolessonstitle/changeStatusFalse/{id}', [VideoLessonsTitleController::class, 'changeStatusFalse'])->name('videolessonstitle.changeStatusFalse');
    Route::get('/videolessonstitle/changeStatusTrue/{id}', [VideoLessonsTitleController::class, 'changeStatusTrue'])->name('videolessonstitle.changeStatusTrue');
});
