<?php

namespace Domain\Types;

/**
 * Data ProviderX Status Types
 */
enum DataProviderXStatus: int
{
    case AUTHORISED = 1;
    case DECLINE = 2;
    case REFUNDED = 3;

    public static function fromName(string $name) {
        $name = strtoupper($name);

        return constant("self::{$name}");
    }
}
