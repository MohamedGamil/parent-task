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
     * @param array $attributes
     * @return self
     */
    public static function fromArray(array $attributes);

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
}
