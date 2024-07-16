<?php

use Illuminate\Support\Facades\Route;
use Modules\Translate\Http\Controllers\TranslateController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('translate', TranslateController::class)->names('translate');
});
Route::post('translate/delete_selected_items', [TranslateController::class, 'delete_selected_items'])->name('translate.delete_selected_items');
