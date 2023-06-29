<?php

namespace Domain\Concerns;

/**
 * Entity interface
 */
interface Entity
{
    /**
     * Create entity from an array of attributes
     *
     * @param array|object $attributes
     * @return self
     */
    public static function fromArray($attributes);

    /**
     * Get entity label
     *
     * @return string
     * @static
     */
    public static function getLabel(): string;

    /**
     * Get entity attributes array
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Set entity attributes
     *
     * @param array $attributes
     * @return self
     */
    public function setAttributes(array $attributes);

    /**
     * Get entity attributes
     *
     * @return array
     */
    public function getAttributes(): array;

    /**
     * Get entity attribute
     *
     * @param string $key Attribute key
     * @param mixed $default Default value
     * @return mixed
     */
    public function getAttribute($key, $default = null);
}
