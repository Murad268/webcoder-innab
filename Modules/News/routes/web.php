<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\NewsController;

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
    Route::resource('news', NewsController::class)->names('news');
    Route::get('/news/changeStatusFalse/{id}', [NewsController::class, 'changeStatusFalse'])->name('news.changeStatusFalse');
    Route::get('/news/changeStatusTrue/{id}', [NewsController::class, 'changeStatusTrue'])->name('news.changeStatusTrue');
    Route::get('/news/deleteFile/{id}', [NewsController::class, 'deleteFile'])->name('news.deleteFile');
});

