<?php

namespace Domain\Entities;

use Domain\Concerns\Entity as IEntity;

/**
 * Base Entity
 */
abstract class Entity implements IEntity
{
    /**
     * Enable / Disable Strict Entity Attributes
     */
    const STRICT_ATTRIBUTES = true;

    /**
     * Entity attributes
     */
    protected array $attributes;

    public static function fromArray(array $attributes)
    {
        return (new static)->setAttributes(
            $attributes
        );
    }

    public function toArray(): array
    {
        return $this->attributes ?? [];
    }

    public function setAttributes(array $attributes)
    {
        $allowed = array_keys(
            $this->attributes ?? []
        );

        if (false === empty($allowed) && true === static::STRICT_ATTRIBUTES) {
            $this->attributes = collect($attributes)
                ->only($allowed)
                ->toArray();
        }
        else {
            $this->attributes = $attributes;
        }

        return $this;
    }
}
