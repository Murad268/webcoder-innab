<?php

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\AboutController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('about', AboutController::class)->names('about');
});
Route::post('about/delete_selected_items', [AboutController::class, 'delete_selected_items'])->name('about.delete_selected_items');
