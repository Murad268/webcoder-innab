<?php

use Illuminate\Support\Facades\Route;
use Modules\CourseFAQ\Http\Controllers\CourseFAQApiController;
use Modules\CourseFAQ\Http\Controllers\CourseFAQController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('coursefaq/delete_selected_items', [CourseFAQController::class, 'delete_selected_items'])->name('coursefaq.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_faq/{id}', [CourseFAQApiController::class, 'get_faq'])->name('coursefaq.get_faq');
});
