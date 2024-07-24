<?php

use Illuminate\Support\Facades\Route;
use Modules\Lesson\Http\Controllers\LessonController;

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
    Route::apiResource('lesson', LessonController::class)->names('lesson');
});
Route::post('lesson/delete_selected_items', [LessonController::class, 'delete_selected_items'])->name('lesson.delete_selected_items');

use Modules\Lesson\Http\Controllers\LessonApiController;

Route::prefix('{locale}')->group(function () {
    Route::get('/get_lesson/{id}', [LessonApiController::class, 'get_lesson'])->name('lesson.get_name');
});
