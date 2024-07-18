<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\NewsController;

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
    Route::apiResource('news', NewsController::class)->names('news');
});
Route::post('news/delete_selected_items', [NewsController::class, 'delete_selected_items'])->name('news.delete_selected_items');
Route::post('news/pin', [NewsController::class, 'pin'])->name('news.pin');
Route::post('news/unpin', [NewsController::class, 'unpin'])->name('news.unpin');

