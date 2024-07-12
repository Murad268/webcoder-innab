<?php

use Illuminate\Support\Facades\Route;
use Modules\BlogContent\Http\Controllers\BlogContentController;

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
    Route::resource('blogcontent', BlogContentController::class)->names('blogcontent');
    Route::get('/blogcontent/changeStatusFalse/{id}', [BlogContentController::class, 'changeStatusFalse'])->name('blogcontent.changeStatusFalse');
    Route::get('/blogcontent/changeStatusTrue/{id}', [BlogContentController::class, 'changeStatusTrue'])->name('blogcontent.changeStatusTrue');
    Route::get('/blogcontent/deleteFile/{id}', [BlogContentController::class, 'deleteFile'])->name('blogcontent.deleteFile');
});
