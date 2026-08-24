<?php

namespace App\Http\Controllers;

use App\Services\WorkshopApi;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServicePhotosController extends Controller
{
    public function __invoke(int $id, string $type, WorkshopApi $api): Response
    {
        if (! in_array($type, ['before', 'after'], true)) {
            abort(404);
        }

        $response = $api->servicePhotosPage($id, $type);

        if ($response->status() === 404) {
            abort(404);
        }

        if (! $response->successful()) {
            throw new HttpException(502, 'Gagal mengambil halaman foto dari workshop.');
        }

        return response($response->body(), 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }
}
