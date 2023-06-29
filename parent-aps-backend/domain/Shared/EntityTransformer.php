<?php

namespace Domain\Shared;

use Domain\Concerns\Entity as IEntity;
use Domain\Entities\Entity;
use Domain\Exceptions\IncompatibleEntity;
use Domain\Types\Entities;

/**
 * Entity Transformer Trait
 *
 * @property-read array $supportedEntities
 * @property-read array $supportedEntitiesMap
 * @property-read string $supportedEntityKey
 */
trait EntityTransformer
{
    public static function fromEntity(Entities $entityClass, array $attributes)
    {
        /** @var Entity $entity */
        $entityClass_ = $entityClass->value;
        $entity = $entityClass_::fromArray($attributes);
        $map = static::getSupportedEntitiesMap();
        $entityMap = isset($map[$entityClass_])
            ? $map[$entityClass_]
            : null;

        if (false === static::isSupportedEntity($entityClass) || true === empty($entityMap)) {
            throw new IncompatibleEntity(
                "Trying to tranform from incompatible entity: '{$entityClass_}'."
            );
        }

        $fromKey = static::getSupportedEntityKey();
        $mapped = true === empty($fromKey)
            ? []
            : [
                $fromKey => class_basename($entityClass_)
            ];

        foreach($entityMap as $fromField => $toField) {
            $mapped[$toField] = $entity->getAttribute($fromField);
        }

        return static::fromArray($mapped);
    }

    public static function getSupportedEntities(): array
    {
        return static::$supportedEntities;
    }

    public static function isSupportedEntity(Entities $entityClass): bool
    {
        return in_array(
            $entityClass->value,
            static::getSupportedEntities(),
            true
        );
    }

    public static function getSupportedEntitiesMap(): array
    {
        return static::$supportedEntitiesMap;
    }

    public static function getSupportedEntityKey(): string
    {
        return static::$supportedEntityKey;
    }

    public function toEntity(Entities $targetEntity): Entity
    {
        $targetEntity_ = $targetEntity->value;
        $map = static::getSupportedEntitiesMap();
        $entityMap = isset($map[$targetEntity_])
            ? $map[$targetEntity_]
            : null;

        if (false === static::isSupportedEntity($targetEntity) || true === empty($entityMap)) {
            throw new IncompatibleEntity(
                "Trying to tranform to incompatible entity: '{$targetEntity_}'."
            );
        }

        $mapped = [];
        $entityMap = array_flip($entityMap);

        foreach($entityMap as $fromField => $toField) {
            $mapped[$toField] = $this->getAttribute($fromField);
        }

        return $targetEntity_::fromArray($mapped);
    }
}
