<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

class BadJsonDataSourceFile extends RuntimeException
{
    public function __construct(
        string $message = 'Invalid JSON data source file',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
