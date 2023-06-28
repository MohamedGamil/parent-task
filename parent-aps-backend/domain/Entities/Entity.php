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
     * Entity label
     *
     * @static
     */
    protected static string $label;

    /**
     * Entity attributes
     */
    protected array $attributes;

    public static function fromArray($attributes)
    {
        return (new static)->setAttributes(
            (array) $attributes
        );
    }

    public static function getLabel(): string
    {
        return static::$label;
    }

    public function toArray(): array
    {
        return collect(
            $this->getAttributes()
        )->toArray();
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        $allowed = array_keys(
            $this->getAttributes()
        );

        if (false === empty($allowed) && true === static::STRICT_ATTRIBUTES) {
            $this->attributes = collect($attributes)
                ->only($allowed)
                ->toArray();
        }

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes ?? [];
    }

    public function getAttribute($key, $default = null)
    {
        return isset($this->attributes[$key])
            ? $this->attributes[$key]
            : $default;
    }
}
