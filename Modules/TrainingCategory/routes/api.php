<?php

use Illuminate\Support\Facades\Route;
use Modules\TrainingCategory\Http\Controllers\TrainingCategoryController;

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
    Route::apiResource('trainingcategory', TrainingCategoryController::class)->names('trainingcategory');
});
Route::post('trainingcategory/delete_selected_items', [TrainingCategoryController::class, 'delete_selected_items'])->name('trainingcategory.delete_selected_items');
