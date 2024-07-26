<?php

use Illuminate\Support\Facades\Route;
use Modules\Lesson\Http\Controllers\LessonController;
use Modules\Lesson\Http\Controllers\LessonApiController;

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
    Route::post('lesson/delete_selected_items', [LessonController::class, 'delete_selected_items'])->name('lesson.delete_selected_items');


    Route::post('lesson/get_titles', [LessonController::class, 'get_titles'])->name('lesson.get_titles');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_lesson/{id}', [LessonApiController::class, 'get_lesson'])->name('lesson.get_lesson');
});
