<?php

namespace App\Exceptions;

use Exception;

class RefreshTokenNotFoundException extends Exception
{
    public function __construct(string $message = "Refresh token not found in database")
    {
        parent::__construct($message, 401);
    }
}