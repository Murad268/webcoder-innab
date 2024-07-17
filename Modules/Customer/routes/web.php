<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\CustomerController;

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

Route::group(['prefix' =>'admin', 'middleware' => 'auth'], function () {
    Route::resource('customer', CustomerController::class)->names('customer');
    Route::get('/customer/changeStatusFalse/{id}', [CustomerController::class, 'changeStatusFalse'])->name('customer.changeStatusFalse');
    Route::get('/customer/changeStatusTrue/{id}', [CustomerController::class, 'changeStatusTrue'])->name('customer.changeStatusTrue');
    Route::get('/customer/deleteFile/{id}', [CustomerController::class, 'deleteFile'])->name('customer.deleteFile');
});
