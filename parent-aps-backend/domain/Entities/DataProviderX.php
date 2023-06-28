<?php

namespace Domain\Entities;

use Domain\Types\DataProviderX as TDataProviderX;

/**
 * Data ProviderX Entity
 */
final class DataProviderX extends Entity
{
    protected array $attributes = [
        TDataProviderX::PARENT_EMAIL => null,
        TDataProviderX::PARENT_IDENTIFICATION => null,
        TDataProviderX::PARENT_AMOUNT => null,
        TDataProviderX::CURRENCY => null,
        TDataProviderX::STATUS_CODE => null,
        TDataProviderX::REGISTERATION_DATE => null,
    ];
}
