<?php

use Illuminate\Support\Facades\Route;
use Modules\ScholarshipProgram\Http\Controllers\ScholarshipProgramController;
use Modules\ScholarshipProgram\Http\Controllers\ScholarshipProgramApiController;


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('scholarshipprogram/delete_selected_items', [ScholarshipProgramController::class, 'delete_selected_items'])->name('scholarshipprogram.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_scholarshipprogram', [ScholarshipProgramApiController::class, 'get_scholarshipprogram'])->name('scholarshipprogram.get_scholarshipprogram');
});
