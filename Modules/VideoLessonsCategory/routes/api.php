<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessonsCategory\Http\Controllers\VideoLessonsCategoryController;


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

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('videolessonscategory', VideoLessonsCategoryController::class)->names('videolessonscategory');
});
Route::post('videolessonscategory/delete_selected_items', [VideoLessonsCategoryController::class, 'delete_selected_items'])->name('videolessonscategory.delete_selected_items');






use Modules\VideoLessonsCategory\Http\Controllers\VideoLessonsCategoryApiController;

Route::prefix('{locale}')->group(function () {
    Route::get('/get_videolessonscategory', [VideoLessonsCategoryApiController::class, 'get_videolessonscategory'])->name('videolessonscategory.get_videolessonscategory');
});
