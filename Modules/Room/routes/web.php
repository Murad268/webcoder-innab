<?php

use Illuminate\Support\Facades\Route;
use Modules\Room\Http\Controllers\RoomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => "admin"], function () {
    Route::resource('room', RoomController::class)->names('room');
    Route::get('/room/changeStatusFalse/{id}', [RoomController::class, 'changeStatusFalse'])->name('room.changeStatusFalse');
    Route::get('/room/changeStatusTrue/{id}', [RoomController::class, 'changeStatusTrue'])->name('room.changeStatusTrue');
    Route::get('/room/deleteFile/{id}', [RoomController::class, 'deleteFile'])->name('room.deleteFile');
});
