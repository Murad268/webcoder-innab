<?php

use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\MenuController;

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
    Route::resource('menu', MenuController::class)->names('menu');
    Route::get('/menu/changeStatusFalse/{id}', [MenuController::class, 'changeStatusFalse'])->name('menu.changeStatusFalse');
    Route::get('/menu/changeStatusTrue/{id}', [MenuController::class, 'changeStatusTrue'])->name('menu.changeStatusTrue');
    Route::get('/menu/deleteFile/{id}', [MenuController::class, 'deleteFile'])->name('menu.deleteFile');
});
