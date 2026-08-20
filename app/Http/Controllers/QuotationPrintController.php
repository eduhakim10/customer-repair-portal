<?php

namespace App\Http\Controllers;

use App\Services\WorkshopApi;
use Illuminate\Http\Response;

class QuotationPrintController extends Controller
{
    public function __invoke(int $id, WorkshopApi $api): Response
    {
        $quotation = $api->quotation($id);

        if (! $quotation) {
            abort(404);
        }

        $html = view('prints.quotation', compact('quotation'))->render();

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }
}
