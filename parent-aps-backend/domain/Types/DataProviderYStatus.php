<?php

namespace Domain\Types;

/**
 * Data ProviderY Status Types
 */
enum DataProviderYStatus: int
{
    case AUTHORISED = 100;
    case DECLINE = 200;
    case REFUNDED = 300;

    public static function fromName(string $name) {
        $name = strtoupper($name);

        return constant("self::{$name}");
    }
}
