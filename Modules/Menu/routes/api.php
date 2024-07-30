<?php

use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\MenuController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('menu', MenuController::class)->names('menu');
});
Route::post('menu/delete_selected_items', [MenuController::class, 'delete_selected_items'])->name('menu.delete_selected_items');
