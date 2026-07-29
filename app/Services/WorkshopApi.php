<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

/**
 * Thin HTTP client for the workshop-app customer API.
 * The Sanctum bearer token is stored in the session after login.
 */
class WorkshopApi
{
    public const SESSION_TOKEN = 'workshop_api_token';
    public const SESSION_USER = 'workshop_api_user';

    private string $baseUrl;
    private bool $verify;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.workshop.base_url'), '/') . '/api/customer';
        $this->verify = (bool) config('services.workshop.verify', false);
    }

    /** Authenticate and persist token + user in the session. Returns user payload or null. */
    public function login(string $email, string $password): ?array
    {
        $response = $this->client(false)->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();
        Session::put(self::SESSION_TOKEN, $data['token'] ?? null);
        Session::put(self::SESSION_USER, $data['user'] ?? null);

        return $data['user'] ?? null;
    }

    public function logout(): void
    {
        try {
            if ($this->token()) {
                $this->client()->post('/logout');
            }
        } catch (\Throwable) {
            // ignore network errors on logout
        }

        Session::forget(self::SESSION_TOKEN);
        Session::forget(self::SESSION_USER);
    }

    public function token(): ?string
    {
        return Session::get(self::SESSION_TOKEN);
    }

    public function user(): ?array
    {
        return Session::get(self::SESSION_USER);
    }

    public function dashboard(): array
    {
        return $this->client()->get('/dashboard')->json() ?? [];
    }

    public function quotations(): array
    {
        return $this->client()->get('/quotations')->json('data') ?? [];
    }

    public function quotation(int $id): ?array
    {
        $res = $this->client()->get("/quotations/{$id}");

        return $res->successful() ? $res->json('data') : null;
    }

    /**
     * @param  \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|\Illuminate\Http\UploadedFile  $file
     */
    public function uploadPo(int $id, string $poNumber, string $poDate, $file): Response
    {
        return $this->client()
            ->attach(
                'po_file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName() ?: 'po.pdf',
            )
            ->post("/quotations/{$id}/upload-po", [
                'po_number' => $poNumber,
                'po_date' => $poDate,
            ]);
    }

    public function users(): array
    {
        return $this->client()->get('/users')->json('data') ?? [];
    }

    public function createUser(array $payload): Response
    {
        return $this->client()->post('/users', $payload);
    }

    public function updateUser(int $id, array $payload): Response
    {
        return $this->client()->put("/users/{$id}", $payload);
    }

    public function deleteUser(int $id): Response
    {
        return $this->client()->delete("/users/{$id}");
    }

    private function client(bool $withToken = true): PendingRequest
    {
        $client = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->withOptions(['verify' => $this->verify])
            ->timeout(30);

        if ($withToken && $this->token()) {
            $client = $client->withToken($this->token());
        }

        return $client;
    }
}
