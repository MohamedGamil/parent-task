<?php

namespace Domain\Entities;

use Domain\Types\DataProviderX as TDataProviderX;

/**
 * Data ProviderX Entity
 */
final class DataProviderX extends Entity
{
    protected static string $label = 'DataProviderX';

    protected array $attributes = [
        TDataProviderX::PARENT_EMAIL->value => null,
        TDataProviderX::PARENT_IDENTIFICATION->value => null,
        TDataProviderX::PARENT_AMOUNT->value => null,
        TDataProviderX::CURRENCY->value => null,
        TDataProviderX::STATUS_CODE->value => null,
        TDataProviderX::REGISTERATION_DATE->value => null,
    ];
}
