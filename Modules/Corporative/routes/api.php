<?php

use Illuminate\Support\Facades\Route;
use Modules\Corporative\Http\Controllers\CorporativeController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('corporative', CorporativeController::class)->names('corporative');
});
Route::post('corporative/delete_selected_items', [CorporativeController::class, 'delete_selected_items'])->name('corporative.delete_selected_items');

use Modules\Corporative\Http\Controllers\CorporativeApiController;

Route::prefix('{locale}')->group(function () {
    Route::get('/get_corporative', [CorporativeApiController::class, 'get_corporative'])->name('corporative.get_corporative');
});