<?php

namespace App\Auth;

use App\Services\WorkshopApi;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Session;

/**
 * Reconstructs the authenticated PortalUser from the session payload that was
 * stored during API login. Authentication itself happens against the API in the
 * custom Login page, so credential methods here are intentionally minimal.
 */
class PortalUserProvider implements UserProvider
{
    public function retrieveById($identifier): ?Authenticatable
    {
        $user = Session::get(WorkshopApi::SESSION_USER);

        if (! $user || (int) ($user['id'] ?? 0) !== (int) $identifier) {
            return null;
        }

        // A valid session must still hold an API token.
        if (! Session::get(WorkshopApi::SESSION_TOKEN)) {
            return null;
        }

        return PortalUser::fromArray($user);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void {}

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return false;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void {}
}
