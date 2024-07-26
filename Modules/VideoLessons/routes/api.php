<?php

use Illuminate\Support\Facades\Route;
use Modules\VideoLessons\Http\Controllers\VideoLessonsController;
use Modules\VideoLessons\Http\Controllers\VideoLessonsApiController;

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
    Route::post('videolessons/delete_selected_items', [VideoLessonsController::class, 'delete_selected_items'])->name('videolessons.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_videolessons/{id}', [VideoLessonsApiController::class, 'get_videolessons'])->name('videolessons.get_name');
});
