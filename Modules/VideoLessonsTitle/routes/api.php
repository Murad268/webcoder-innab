<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessonsTitle\Http\Controllers\VideoLessonsTitleController;

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
    Route::apiResource('videolessonstitle', VideoLessonsTitleController::class)->names('videolessonstitle');
});
Route::post('videolessonstitle/delete_selected_items', [VideoLessonsTitleController::class, 'delete_selected_items'])->name('videolessonstitle.delete_selected_items');
