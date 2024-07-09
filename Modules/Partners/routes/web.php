<?php

use Illuminate\Support\Facades\Route;
use Modules\Partners\Http\Controllers\PartnersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => "admin"], function () {
    Route::resource('partners', PartnersController::class)->names('partners');
    Route::get('/partners/changeStatusFalse/{id}', [PartnersController::class, 'changeStatusFalse'])->name('partners.changeStatusFalse');
    Route::get('/partners/changeStatusTrue/{id}', [PartnersController::class, 'changeStatusTrue'])->name('partners.changeStatusTrue');
    Route::get('/partners/deleteFile/{id}', [PartnersController::class, 'deleteFile'])->name('partners.deleteFile');
});
