<?php

namespace Domain\Types;

/**
 * Aggregated Payment Attributes
 */
enum AggregatedPayment: string
{
    case DATA_PROVIDER = 'data_provider';
    case PARENT_EMAIL = 'parent_email';
    case PARENT_IDENTIFICATION = 'parent_id';
    case PARENT_AMOUNT = 'parent_amount';
    case CURRENCY = 'currency';
    case STATUS_CODE = 'status_code';
    case REGISTERATION_DATE = 'registeration_date';
}
