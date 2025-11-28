<?php

namespace App\Exceptions;

use Exception;

class CartEmptyException extends Exception
{
    public function __construct(string $message = "Cannot perform operation on empty cart")
    {
        parent::__construct($message, 400);
    }
}