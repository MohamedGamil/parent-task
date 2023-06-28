<?php

namespace Domain\Concerns;

use Domain\Entities\Entity;
use Domain\Types\Entities;

/**
 * Entity Transformer interface
 */
interface EntityTransformer
{
    /**
     * Create instance from a compatible entity
     *
     * @param Entities $entityClass
     * @param array $attributes
     * @return self
     */
    public static function fromEntity(Entities $entityClass, array $attributes);

    /**
     * Get compatible entities
     *
     * @return Entities[]
     * @static
     */
    public static function getSupportedEntities(): array;

    /**
     * Get compatible entities attributes map
     *
     * @return array
     * @static
     */
    public static function getSupportedEntitiesMap(): array;

    /**
     * Transform to a compatible entity
     *
     * @param Entities $targetEntity
     * @return Entity
     */
    public function toEntity(Entities $targetEntity): Entity;
}
