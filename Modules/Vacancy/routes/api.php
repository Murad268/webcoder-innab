<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\VacancyController;
use Modules\Vacancy\Http\Controllers\VacancyApiController;


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('vacancy/delete_selected_items', [VacancyController::class, 'delete_selected_items'])->name('vacancy.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_vacancy', [VacancyApiController::class, 'get_vacancy'])->name('vacancy.get_vacancy');
});
