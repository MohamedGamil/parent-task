<?php

namespace Domain\Types;

/**
 * Data ProviderY Attributes
 */
enum DataProviderY: string
{
    case ID = 'id';
    case EMAIL = 'email';
    case STATUS = 'status';
    case BALANCE = 'balance';
    case CURRENCY = 'currency';
    case CREATED_AT = 'created_at';
}
