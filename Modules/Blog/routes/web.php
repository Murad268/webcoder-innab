<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;

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
    Route::resource('blog', BlogController::class)->names('blog');
    Route::get('/blog/changeStatusFalse/{id}', [BlogController::class, 'changeStatusFalse'])->name('blog.changeStatusFalse');
    Route::get('/blog/changeStatusTrue/{id}', [BlogController::class, 'changeStatusTrue'])->name('blog.changeStatusTrue');
    Route::get('/blog/deleteFile/{id}', [BlogController::class, 'deleteFile'])->name('blog.deleteFile');
});
