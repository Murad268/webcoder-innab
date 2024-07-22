<?php

use Illuminate\Support\Facades\Route;
use Modules\HeaderDatas\Http\Controllers\HeaderDataApiController;
use Modules\HeaderDatas\Http\Controllers\HeaderDatasController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('headerdatas', HeaderDatasController::class)->names('headerdatas');
});

Route::post('headerdatas/delete_selected_items', [HeaderDatasController::class, 'delete_selected_items'])->name('headerdatas.delete_selected_items');


Route::get('/get_headerdatas', [HeaderDataApiController::class, 'get_headerdatas'])->name('get_headerdatas');
