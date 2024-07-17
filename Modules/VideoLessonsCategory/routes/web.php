<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessonsCategory\Http\Controllers\VideoLessonsCategoryController;

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
    Route::resource('videolessonscategory', VideoLessonsCategoryController::class)->names('videolessonscategory');
    Route::get('/videolessonscategory/changeStatusFalse/{id}', [VideoLessonsCategoryController::class, 'changeStatusFalse'])->name('videolessonscategory.changeStatusFalse');
    Route::get('/videolessonscategory/changeStatusTrue/{id}', [VideoLessonsCategoryController::class, 'changeStatusTrue'])->name('videolessonscategory.changeStatusTrue');
});
