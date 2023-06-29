<?php

namespace App\Exceptions;

use Throwable;

class IncompatibleJsonDataSourceModes extends JsonDataSourceException
{
    public function __construct(
        string $message = 'Enabled modes for this data source are incompatible.',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
