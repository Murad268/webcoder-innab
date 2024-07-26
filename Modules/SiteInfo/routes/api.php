<?php

use Illuminate\Support\Facades\Route;
use Modules\SiteInfo\Http\Controllers\SiteInfoController;
use Modules\SiteInfo\Http\Controllers\SiteInfoApiController;


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('siteinfo/delete_selected_items', [SiteInfoController::class, 'delete_selected_items'])->name('siteinfo.delete_selected_items');
});



Route::prefix('{locale}')->group(function () {
    Route::get('/get_siteinfo', [SiteInfoApiController::class, 'get_siteinfo'])->name('siteinfo.get_siteinfo');
});
