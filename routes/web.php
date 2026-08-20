<?php

use App\Http\Controllers\QuotationPrintController;
use Illuminate\Support\Facades\Route;

/*
| The customer portal is served by the Filament "customer" panel at "/".
| Extra authenticated routes (print) live here.
*/

Route::middleware(['web', 'auth:portal'])->group(function () {
    Route::get('/quotations/{id}/print', QuotationPrintController::class)
        ->whereNumber('id')
        ->name('quotations.print');
});
