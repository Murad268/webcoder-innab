<?php

use Illuminate\Support\Facades\Route;
use Modules\Vebinar\Http\Controllers\VebinarController;
use Modules\Vebinar\Http\Controllers\VebinarApiController;


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('vebinar/delete_selected_items', [VebinarController::class, 'delete_selected_items'])->name('vebinar.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_vebinar', [VebinarApiController::class, 'get_vebinar'])->name('vebinar.get_vebinar');
});
