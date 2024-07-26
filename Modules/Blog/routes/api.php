<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\BlogApiController;

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
    Route::post('blog/delete_selected_items', [BlogController::class, 'delete_selected_items'])->name('blog.delete_selected_items');
});

Route::prefix('{locale}')->group(function () {
    Route::get('/get_blog/{id}', [BlogApiController::class, 'get_blog'])->name('blog.get_name');
});
