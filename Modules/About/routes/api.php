<?php

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\AboutController;
use Modules\About\Http\Controllers\AboutApiController;



Route::middleware(['web', 'auth'])->group(function () {
    Route::post('about/delete_selected_items', [AboutController::class, 'delete_selected_items'])->name('about.delete_selected_items');
});

Route::prefix('{locale}')->group(function () {
    Route::get('/get_about', [AboutApiController::class, 'get_about'])->name('about.get_about');
});
