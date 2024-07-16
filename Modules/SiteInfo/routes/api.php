<?php

use Illuminate\Support\Facades\Route;
use Modules\SiteInfo\Http\Controllers\SiteInfoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('siteinfo', SiteInfoController::class)->names('siteinfo');
});
Route::post('siteinfo/delete_selected_items', [SiteInfoController::class, 'delete_selected_items'])->name('siteinfo.delete_selected_items');
