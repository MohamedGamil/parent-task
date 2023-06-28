<?php

namespace Domain\Entities;

use Domain\Types\DataProviderY as TDataProviderY;

/**
 * Data ProviderY Entity
 */
final class DataProviderY extends Entity
{
    protected static string $label = 'DataProviderY';

    protected array $attributes = [
        TDataProviderY::ID->value => null,
        TDataProviderY::EMAIL->value => null,
        TDataProviderY::STATUS->value => null,
        TDataProviderY::BALANCE->value => null,
        TDataProviderY::CURRENCY->value => null,
        TDataProviderY::CREATED_AT->value => null,
    ];
}
