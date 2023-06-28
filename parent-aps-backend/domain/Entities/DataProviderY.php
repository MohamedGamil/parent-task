<?php

namespace Domain\Entities;

use Domain\Types\DataProviderY as TDataProviderY;

/**
 * Data ProviderY Entity
 */
final class DataProviderY extends Entity
{
    protected array $attributes = [
        TDataProviderY::ID => null,
        TDataProviderY::EMAIL => null,
        TDataProviderY::STATUS => null,
        TDataProviderY::BALANCE => null,
        TDataProviderY::CURRENCY => null,
        TDataProviderY::CREATED_AT => null,
    ];
}
