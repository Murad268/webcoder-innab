<?php

use Illuminate\Support\Facades\Route;
use Modules\Room\Http\Controllers\RoomApiController;
use Modules\Room\Http\Controllers\RoomController;

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
    Route::post('room/delete_selected_items', [RoomController::class, 'delete_selected_items'])->name('room.delete_selected_items');
});

Route::prefix('{locale}')->group(function () {
    Route::get('/get_rooms', [RoomApiController::class, 'get_rooms'])->name('room.get_rooms');
});
