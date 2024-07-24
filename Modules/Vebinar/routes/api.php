<?php

use Illuminate\Support\Facades\Route;
use Modules\Vebinar\Http\Controllers\VebinarController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('vebinar', VebinarController::class)->names('vebinar');
});
Route::post('vebinar/delete_selected_items', [VebinarController::class, 'delete_selected_items'])->name('vebinar.delete_selected_items');

use Modules\Vebinar\Http\Controllers\VebinarApiController;

Route::prefix('{locale}')->group(function () {
    Route::get('/get_vebinar', [VebinarApiController::class, 'get_vebinar'])->name('vebinar.get_vebinar');
});