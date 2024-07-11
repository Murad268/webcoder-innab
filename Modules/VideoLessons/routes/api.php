<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessons\Http\Controllers\VideoLessonsController;

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
    Route::apiResource('videolessons', VideoLessonsController::class)->names('videolessons');
});
Route::post('videolessons/delete_selected_items', [VideoLessonsController::class, 'delete_selected_items'])->name('videolessons.delete_selected_items');
