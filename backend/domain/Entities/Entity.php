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
    const STRICT_ATTRIBUTES = false;

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
        $allowed = array_keys(
            $this->getAttributes()
        );
        
        $this->attributes = $attributes;

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
        $attrs = $this->getAttributes();

        return isset($attrs[$key])
            ? $attrs[$key]
            : $default;
    }
}
