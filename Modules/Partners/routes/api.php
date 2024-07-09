<?php

use Illuminate\Support\Facades\Route;
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

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('partners', PartnersController::class)->names('partners');
});
Route::post('partners/delete_selected_items', [PartnersController::class, 'delete_selected_items'])->name('partners.delete_selected_items');
