<?php

use Illuminate\Support\Facades\Route;
use Modules\Workshop\Http\Controllers\WorkshopController;
use Modules\Workshop\Http\Controllers\WorkshopApiController;


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('workshop/delete_selected_items', [WorkshopController::class, 'delete_selected_items'])->name('workshop.delete_selected_items');
});
Route::prefix('{locale}')->group(function () {
    Route::get('/get_workshop', [WorkshopApiController::class, 'get_workshop'])->name('workshop.get_workshop');
});
