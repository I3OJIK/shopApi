<?php

namespace App\Services\Auth;

use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\Config;

class CookieService
{
    public function makeRefreshCookie(string $refreshToken): Cookie
    {
        return cookie(
            'refresh_token',
            $refreshToken,
            60 * 24 * 30,
            null,
            null,
            true,  // secure (https)
            true   // httpOnly
        );
    }
}