<?php

use Illuminate\Support\Facades\Route;
use Modules\Lang\Http\Controllers\LangController;

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
    Route::resource('lang', LangController::class)->names('lang');
    Route::get('/lang/changeDefault/{id}', [LangController::class, 'changeDefault'])->name('lang.changeDefault');
    Route::get('/lang/changeStatusFalse/{id}', [LangController::class, 'changeStatusFalse'])->name('lang.changeStatusFalse');
    Route::get('/lang/changeStatusTrue/{id}', [LangController::class, 'changeStatusTrue'])->name('lang.changeStatusTrue');
});
