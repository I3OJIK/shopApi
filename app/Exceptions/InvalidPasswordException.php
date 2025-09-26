<?php

namespace App\Exceptions;

use Exception;

class InvalidPasswordException extends Exception
{
    public function __construct(string $message = "Invalid password")
    {
        parent::__construct($message, 401);
    }
}
