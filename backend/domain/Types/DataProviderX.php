<?php

namespace Domain\Types;

/**
 * Data ProviderX Attributes
 */
enum DataProviderX: string
{
    case PARENT_EMAIL = 'parentEmail';
    case PARENT_IDENTIFICATION = 'parentIdentification';
    case PARENT_AMOUNT = 'parentAmount';
    case CURRENCY = 'Currency';
    case STATUS_CODE = 'statusCode';
    case REGISTERATION_DATE = 'registerationDate';
}
