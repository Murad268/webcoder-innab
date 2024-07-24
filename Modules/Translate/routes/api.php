<?php

use Illuminate\Support\Facades\Route;
use Modules\Translate\Http\Controllers\TranslateController;
use Modules\Translate\Http\Controllers\TranslateApiController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('translate', TranslateController::class)->names('translate');
});
Route::post('translate/delete_selected_items', [TranslateController::class, 'delete_selected_items'])->name('translate.delete_selected_items');


Route::prefix('{locale}')->group(function () {
    Route::get('/get_translate', [TranslateApiController::class, 'get_translate'])->name('translate.get_translate');
});
