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
 */
trait EntityTransformer
{
    public static function fromEntity(Entities $entityClass, array $attributes)
    {
        $entityClass = $entityClass->value;

        /** @var string $entityClass */
        /** @var Entity $entity */
        $entity = $entityClass::fromArray($attributes);
        $map = static::getSupportedEntitiesMap();
        $entityAttrs = $entity->getAttributes();
        $entityMap = isset($map[$entityClass])
            ? $map[$entityClass]
            : null;

        if (true === empty($entityMap)) {
            throw new IncompatibleEntity("Trying to tranform from incompatible entity: '{$entityClass}'.");
        }

        $mapped = [];

        foreach($entityMap as $fromField => $toField) {
            $mapped[$toField] = $entity->getAttribute($fromField);
        }

        return static::fromArray($mapped);
    }

    public static function getSupportedEntities(): array
    {
        return static::$supportedEntities;
    }

    public static function getSupportedEntitiesMap(): array
    {
        return static::$supportedEntitiesMap;
    }

    public function toEntity(Entities $targetEntity): Entity
    {
        $targetEntity = $targetEntity->value;

        /** @var string $targetEntity */
        $map = static::getSupportedEntitiesMap();
        $entityMap = isset($map[$targetEntity])
            ? $map[$targetEntity]
            : null;

        if (true === empty($entityMap)) {
            throw new IncompatibleEntity("Trying to tranform to incompatible entity: '{$targetEntity}'.");
        }

        $mapped = [];
        $entityMap = array_flip($entityMap);

        foreach($entityMap as $fromField => $toField) {
            $mapped[$toField] = $this->getAttribute($fromField);
        }

        /** @var Entity $entity */
        $entity = $targetEntity::fromArray($mapped);

        return $entity;
    }
}
