<?php

namespace Domain\Types;

use Domain\Entities\AggregatedPayment;
use Domain\Entities\DataProviderX;
use Domain\Entities\DataProviderY;

/**
 * Entities Definitions
 */
enum Entities: string
{
    case AGGREGATED_PAYMENT = AggregatedPayment::class;
    case DATA_PROVIDER_X = DataProviderX::class;
    case DATA_PROVIDER_Y = DataProviderY::class;

    public static function fromName(string $name) {
        $name = strtoupper(
            \Str::snake($name)
        );

        return constant("self::{$name}");
    }
}
