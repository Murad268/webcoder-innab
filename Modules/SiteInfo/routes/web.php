<?php

use Illuminate\Support\Facades\Route;
use Modules\SiteInfo\Http\Controllers\SiteInfoController;

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
    Route::resource('siteinfo', SiteInfoController::class)->names('siteinfo');
    Route::get('/siteinfo/changeStatusFalse/{id}', [SiteInfoController::class, 'changeStatusFalse'])->name('siteinfo.changeStatusFalse');
    Route::get('/siteinfo/changeStatusTrue/{id}', [SiteInfoController::class, 'changeStatusTrue'])->name('siteinfo.changeStatusTrue');
    Route::get('/siteinfo/deleteFile/{id}', [SiteInfoController::class, 'deleteFile'])->name('siteinfo.deleteFile');
});
