<?php

namespace App\Http\Controllers;

use App\Services\WorkshopApi;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuotationPrintController extends Controller
{
    public function __invoke(int $id, WorkshopApi $api): Response
    {
        $response = $api->quotationPrint($id);

        if ($response->status() === 404) {
            abort(404);
        }

        if ($response->status() === 422) {
            throw new HttpException(422, 'Item penawaran belum diisi. Tidak dapat mencetak.');
        }

        if (! $response->successful()) {
            abort(502, 'Gagal mengambil dokumen penawaran dari workshop.');
        }

        return response($response->body(), 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }
}
