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
}
