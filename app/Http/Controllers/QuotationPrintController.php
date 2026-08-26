<?php

namespace App\Http\Controllers;

use App\Services\WorkshopApi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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

        $html = $this->embedExternalImages($response->body());

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    /**
     * Print HTML comes from workshop-app; any leftover img src pointing at
     * mtikarawang.com (or relative /storage) would break on customer.mtikarawang.com.
     * Convert those to data URIs so the print page is self-contained.
     */
    private function embedExternalImages(string $html): string
    {
        $workshopOrigin = rtrim((string) config('services.workshop.base_url'), '/');

        return (string) preg_replace_callback(
            '/<img\b[^>]*\bsrc=(["\'])([^"\']+)\1[^>]*>/i',
            function (array $m) use ($workshopOrigin) {
                $quote = $m[1];
                $src = html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5);

                if (Str::startsWith($src, 'data:')) {
                    return $m[0];
                }

                $absolute = $this->resolveImageUrl($src, $workshopOrigin);

                if (! $absolute) {
                    return $m[0];
                }

                // Embed workshop storage images (absolute host or relative /storage/...).
                $isWorkshop = $workshopOrigin !== '' && Str::startsWith($absolute, $workshopOrigin);
                $isStorage = Str::contains($absolute, '/storage/');

                if (! $isWorkshop && ! $isStorage) {
                    return $m[0];
                }

                $dataUri = $this->fetchAsDataUri($absolute);

                if (! $dataUri) {
                    return $m[0];
                }

                return str_replace(
                    'src=' . $quote . $m[2] . $quote,
                    'src=' . $quote . $dataUri . $quote,
                    $m[0]
                );
            },
            $html
        );
    }

    private function resolveImageUrl(string $src, string $workshopOrigin): ?string
    {
        if (Str::startsWith($src, ['http://', 'https://'])) {
            return $src;
        }

        if (Str::startsWith($src, '/') && $workshopOrigin !== '') {
            return $workshopOrigin . $src;
        }

        return null;
    }

    private function fetchAsDataUri(string $url): ?string
    {
        try {
            $response = Http::timeout(8)
                ->withOptions(['verify' => (bool) config('services.workshop.verify', false)])
                ->get($url);

            if (! $response->successful()) {
                return null;
            }

            $body = $response->body();

            if ($body === '' || strlen($body) > 5_000_000) {
                return null;
            }

            $mime = trim(explode(';', (string) ($response->header('Content-Type') ?: 'image/png'))[0]);

            if (! Str::startsWith($mime, 'image/')) {
                $mime = 'image/png';
            }

            return 'data:' . $mime . ';base64,' . base64_encode($body);
        } catch (\Throwable) {
            return null;
        }
    }
}
