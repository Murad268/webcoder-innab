<?php

use Illuminate\Support\Facades\Route;
use Modules\BlogContent\Http\Controllers\BlogContentController;
use Modules\BlogContent\Http\Controllers\BlogContentApiController;
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
    Route::apiResource('blogcontent', BlogContentController::class)->names('blogcontent');
});
Route::post('blogcontent/delete_selected_items', [BlogContentController::class, 'delete_selected_items'])->name('blogcontent.delete_selected_items');



Route::prefix('{locale}')->group(function () {
    Route::get('/get_blogcontent/{id}', [BlogContentApiController::class, 'get_blogcontent'])->name('blogcontent.get_name');
});
