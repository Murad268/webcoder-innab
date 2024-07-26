<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessonsCategory\Http\Controllers\VideoLessonsCategoryController;
use Modules\VideoLessonsCategory\Http\Controllers\VideoLessonsCategoryApiController;


/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('videolessonscategory/delete_selected_items', [VideoLessonsCategoryController::class, 'delete_selected_items'])->name('videolessonscategory.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_videolessonscategory', [VideoLessonsCategoryApiController::class, 'get_videolessonscategory'])->name('videolessonscategory.get_videolessonscategory');
});
