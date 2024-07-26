<?php

use Illuminate\Support\Facades\Route;
use Modules\BlogCategory\Http\Controllers\BlogCategoryController;

use Modules\BlogCategory\Http\Controllers\BlogCategoryApiController;
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
    Route::post('blogcategory/delete_selected_items', [BlogCategoryController::class, 'delete_selected_items'])->name('blogcategory.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_blogcategory', [BlogCategoryApiController::class, 'get_blogcategory'])->name('blogcategory.get_name');
});
