<?php

use Illuminate\Support\Facades\Route;
use Modules\HeaderDatas\Http\Controllers\HeaderDatasController;

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

Route::group(['prefix' => "admin", 'middleware' => 'auth'], function () {
    Route::resource('headerdatas', HeaderDatasController::class)->names('headerdatas');
    Route::get('/headerdatas/changeStatusFalse/{id}', [HeaderDatasController::class, 'changeStatusFalse'])->name('headerdatas.changeStatusFalse');
    Route::get('/headerdatas/changeStatusTrue/{id}', [HeaderDatasController::class, 'changeStatusTrue'])->name('headerdatas.changeStatusTrue');
    Route::get('/headerdatas/deleteFile/{id}', [HeaderDatasController::class, 'deleteFile'])->name('headerdatas.deleteFile');
});
