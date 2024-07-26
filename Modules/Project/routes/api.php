<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\ProjectApiController;
use Modules\Project\Http\Controllers\ProjectController;

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
    Route::post('project/delete_selected_items', [ProjectController::class, 'delete_selected_items'])->name('project.delete_selected_items');
});

Route::prefix('{locale}')->group(function () {
    Route::get('/get_projects', [ProjectApiController::class, 'get_projects'])->name('project.get_projects');
});
