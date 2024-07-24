<?php

use Illuminate\Support\Facades\Route;
use Modules\Workshop\Http\Controllers\WorkshopController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('workshop', WorkshopController::class)->names('workshop');
});
Route::post('workshop/delete_selected_items', [WorkshopController::class, 'delete_selected_items'])->name('workshop.delete_selected_items');

use Modules\Workshop\Http\Controllers\WorkshopApiController;

Route::prefix('{locale}')->group(function () {
    Route::get('/get_workshop', [WorkshopApiController::class, 'get_workshop'])->name('workshop.get_workshop');
});