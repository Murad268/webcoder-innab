<?php

use Illuminate\Support\Facades\Route;
use Modules\vebinar\Http\Controllers\vebinarController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('vebinar', vebinarController::class)->names('vebinar');
});
Route::post('vebinar/delete_selected_items', [vebinarController::class, 'delete_selected_items'])->name('vebinar.delete_selected_items');
