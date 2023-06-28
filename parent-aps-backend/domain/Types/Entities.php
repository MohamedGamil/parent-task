<?php

namespace Domain\Types;

use Domain\Entities\AggregatedPayment;
use Domain\Entities\DataProviderY;
use Domain\Entities\DataProviderX;

/**
 * Entities Definitions
 */
enum Entities: string
{
    case AGGREGATED_PAYMENT = AggregatedPayment::class;
    case DATA_PROVIDER_Y = DataProviderY::class;
    case DATA_PROVIDER_X = DataProviderX::class;
}
