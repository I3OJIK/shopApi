<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(
       protected int $availableStock
    )
    {
        $message = "Insufficient Stock";
        parent::__construct($message, 422);
    }

    public function getAvailableStock(): int
    {
        return $this->availableStock;
    }
}
