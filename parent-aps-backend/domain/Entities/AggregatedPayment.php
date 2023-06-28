<?php

namespace Domain\Entities;

use Domain\Concerns\EntityTransformer;
use Domain\Shared\EntityTransformer as Transformer;
use Domain\Types\AggregatedPayment as TAggregatedPayment;
use Domain\Types\DataProviderX as TDataProviderX;
use Domain\Types\DataProviderY as TDataProviderY;
use Domain\Types\Entities;

/**
 * Aggregated Payment Entity
 */
final class AggregatedPayment extends Entity implements EntityTransformer
{
    use Transformer;

    protected static string $label = 'AggregatedPayment';

    protected static $supportedEntities = [
        Entities::DATA_PROVIDER_X->value,
        Entities::DATA_PROVIDER_Y->value,
    ];

    protected static $supportedEntitiesMap = [
        Entities::DATA_PROVIDER_X->value => [
            TDataProviderX::PARENT_IDENTIFICATION->value => TAggregatedPayment::PARENT_IDENTIFICATION->value,
            TDataProviderX::PARENT_EMAIL->value => TAggregatedPayment::PARENT_EMAIL->value,
            TDataProviderX::STATUS_CODE->value => TAggregatedPayment::STATUS_CODE->value,
            TDataProviderX::PARENT_AMOUNT->value => TAggregatedPayment::PARENT_AMOUNT->value,
            TDataProviderX::CURRENCY->value => TAggregatedPayment::CURRENCY->value,
            TDataProviderX::REGISTERATION_DATE->value => TAggregatedPayment::REGISTERATION_DATE->value,
        ],
        Entities::DATA_PROVIDER_Y->value => [
            TDataProviderY::ID->value => TAggregatedPayment::PARENT_IDENTIFICATION->value,
            TDataProviderY::EMAIL->value => TAggregatedPayment::PARENT_EMAIL->value,
            TDataProviderY::STATUS->value => TAggregatedPayment::STATUS_CODE->value,
            TDataProviderY::BALANCE->value => TAggregatedPayment::PARENT_AMOUNT->value,
            TDataProviderY::CURRENCY->value => TAggregatedPayment::CURRENCY->value,
            TDataProviderY::CREATED_AT->value => TAggregatedPayment::REGISTERATION_DATE->value,
        ],
    ];

    protected array $attributes = [
        TAggregatedPayment::PARENT_EMAIL->value => null,
        TAggregatedPayment::PARENT_IDENTIFICATION->value => null,
        TAggregatedPayment::PARENT_AMOUNT->value => null,
        TAggregatedPayment::CURRENCY->value => null,
        TAggregatedPayment::STATUS_CODE->value => null,
        TAggregatedPayment::REGISTERATION_DATE->value => null,
    ];
}
