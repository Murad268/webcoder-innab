<?php

use Illuminate\Support\Facades\Route;
use Modules\TrainingCategory\Http\Controllers\TrainingCategoryApiController;
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


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('trainingcategory/delete_selected_items', [TrainingCategoryController::class, 'delete_selected_items'])->name('trainingcategory.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_categories', [TrainingCategoryApiController::class, 'get_categories'])->name('trainingcategory.get_categories');
});
