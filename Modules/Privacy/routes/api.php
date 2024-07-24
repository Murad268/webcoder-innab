<?php

use Illuminate\Support\Facades\Route;
use Modules\Privacy\Http\Controllers\PrivacyController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('privacy', PrivacyController::class)->names('privacy');
});
Route::post('privacy/delete_selected_items', [PrivacyController::class, 'delete_selected_items'])->name('privacy.delete_selected_items');

use Modules\Privacy\Http\Controllers\PrivacyApiController;

Route::prefix('{locale}')->group(function () {
    Route::get('/get_privacy', [PrivacyApiController::class, 'get_privacy'])->name('privacy.get_privacy');
});