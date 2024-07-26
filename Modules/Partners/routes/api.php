<?php

use Illuminate\Support\Facades\Route;
use Modules\Partners\Http\Controllers\PartnersApiController;
use Modules\Partners\Http\Controllers\PartnersController;

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
    Route::post('partners/delete_selected_items', [PartnersController::class, 'delete_selected_items'])->name('partners.delete_selected_items');
});


Route::prefix('{locale}')->group(function () {
    Route::get('/get_partners', [PartnersApiController::class, 'get_partners'])->name('partners.get_partners');
});
