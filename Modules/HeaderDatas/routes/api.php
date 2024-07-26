<?php

use Illuminate\Support\Facades\Route;
use Modules\HeaderDatas\Http\Controllers\HeaderDataApiController;
use Modules\HeaderDatas\Http\Controllers\HeaderDatasController;



Route::middleware(['web', 'auth'])->group(function () {
    Route::post('headerdatas/delete_selected_items', [HeaderDatasController::class, 'delete_selected_items'])->name('headerdatas.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_headerdatas', [HeaderDataApiController::class, 'get_headerdatas'])->name('get_headerdatas');
});
