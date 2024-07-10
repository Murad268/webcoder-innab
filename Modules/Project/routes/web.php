<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\ProjectController;

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
    Route::resource('project', ProjectController::class)->names('project');
    Route::get('/project/changeStatusFalse/{id}', [ProjectController::class, 'changeStatusFalse'])->name('project.changeStatusFalse');
    Route::get('/project/changeStatusTrue/{id}', [ProjectController::class, 'changeStatusTrue'])->name('project.changeStatusTrue');
    Route::get('/project/deleteFile/{id}', [ProjectController::class, 'deleteFile'])->name('project.deleteFile');
});
