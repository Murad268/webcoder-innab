<?php

use Illuminate\Support\Facades\Route;
use Modules\BlogCategory\Http\Controllers\BlogCategoryController;

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

Route::group(['prefix' => 'admin'], function () {
    Route::resource('blogcategory', BlogCategoryController::class)->names('blogcategory');
    Route::get('/blogcategory/changeStatusFalse/{id}', [BlogCategoryController::class, 'changeStatusFalse'])->name('blogcategory.changeStatusFalse');
    Route::get('/blogcategory/changeStatusTrue/{id}', [BlogCategoryController::class, 'changeStatusTrue'])->name('blogcategory.changeStatusTrue');
});
