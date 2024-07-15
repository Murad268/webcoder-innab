<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\VacancyController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('vacancy', VacancyController::class)->names('vacancy');
});
Route::post('vacancy/delete_selected_items', [VacancyController::class, 'delete_selected_items'])->name('vacancy.delete_selected_items');
