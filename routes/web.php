<?php

use App\Http\Controllers\QuotationPrintController;
use App\Http\Controllers\ServicePhotosController;
use Illuminate\Support\Facades\Route;

/*
| The customer portal is served by the Filament "customer" panel at "/".
| Extra authenticated routes (print, service photos) live here.
*/

Route::middleware(['web', 'auth:portal'])->group(function () {
    Route::get('/quotations/{id}/print', QuotationPrintController::class)
        ->whereNumber('id')
        ->name('quotations.print');

    Route::get('/services/{id}/photos/{type}', ServicePhotosController::class)
        ->whereNumber('id')
        ->whereIn('type', ['before', 'after'])
        ->name('services.photos');
});
