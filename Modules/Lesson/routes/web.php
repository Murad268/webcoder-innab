<?php

use Illuminate\Support\Facades\Route;
use Modules\Lesson\Http\Controllers\LessonController;

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
    Route::resource('lesson', LessonController::class)->names('lesson');
    Route::get('/lesson/changeStatusFalse/{id}', [LessonController::class, 'changeStatusFalse'])->name('lesson.changeStatusFalse');
    Route::get('/lesson/changeStatusTrue/{id}', [LessonController::class, 'changeStatusTrue'])->name('lesson.changeStatusTrue');
});
