<?php

namespace Domain\Exceptions;

use Throwable;

class IncompatibleEntity extends DomainException
{
    public function __construct(
        string $message = 'Trying to convert from/to an incompatible entity.',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
