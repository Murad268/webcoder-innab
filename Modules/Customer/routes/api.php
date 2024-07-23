<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\CustomerApiController;
use Modules\Customer\Http\Controllers\CustomerController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('customer', CustomerController::class)->names('customer');
});
Route::post('customer/delete_selected_items', [CustomerController::class, 'delete_selected_items'])->name('customer.delete_selected_items');



Route::prefix('{locale}')->group(function () {
    Route::get('/get_customers', [CustomerApiController::class, 'get_customers'])->name('customer.get_customers');
});
