<?php

use Illuminate\Support\Facades\Route;
use Modules\TrainingSubject\Http\Controllers\TrainingSubjectController;

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
    Route::post('trainingsubject/delete_selected_items', [TrainingSubjectController::class, 'delete_selected_items'])->name('trainingsubject.delete_selected_items');
});

