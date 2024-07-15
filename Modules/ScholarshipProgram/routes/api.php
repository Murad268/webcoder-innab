<?php

use Illuminate\Support\Facades\Route;
use Modules\ScholarshipProgram\Http\Controllers\ScholarshipProgramController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('scholarshipprogram', ScholarshipProgramController::class)->names('scholarshipprogram');
});
Route::post('scholarshipprogram/delete_selected_items', [ScholarshipProgramController::class, 'delete_selected_items'])->name('scholarshipprogram.delete_selected_items');
