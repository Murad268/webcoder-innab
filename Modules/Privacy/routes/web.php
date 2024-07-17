<?php

use Illuminate\Support\Facades\Route;
use Modules\Privacy\Http\Controllers\PrivacyController;

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

Route::group(['prefix' =>"admin", 'middleware' => 'auth'], function () {
    Route::resource('privacy', PrivacyController::class)->names('privacy');
    Route::get('/privacy/changeStatusFalse/{id}', [PrivacyController::class, 'changeStatusFalse'])->name('privacy.changeStatusFalse');
    Route::get('/privacy/changeStatusTrue/{id}', [PrivacyController::class, 'changeStatusTrue'])->name('privacy.changeStatusTrue');
    Route::get('/privacy/deleteFile/{id}', [PrivacyController::class, 'deleteFile'])->name('privacy.deleteFile');
});
