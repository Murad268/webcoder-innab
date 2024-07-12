<?php

use Illuminate\Support\Facades\Route;
use Modules\BlogCategory\Http\Controllers\BlogCategoryController;

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
    Route::apiResource('blogcategory', BlogCategoryController::class)->names('blogcategory');
});
Route::post('blogcategory/delete_selected_items', [BlogCategoryController::class, 'delete_selected_items'])->name('blogcategory.delete_selected_items');
