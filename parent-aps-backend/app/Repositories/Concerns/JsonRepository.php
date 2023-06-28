<?php

namespace App\Repositories\Concerns;

use Illuminate\Support\Collection;

/**
 * Json Repository Contract
 */
interface JsonRepository extends Repository
{
    /**
     * Get json file name for resource initialization configuration
     *
     * @return array
     */
    public static function getJsonDataSourceConfig(): array;

    /**
     * Start a new query
     *
     * @return Collection
     */
    public function query(): Collection;

    /**
     * Filter items using a callback
     *
     * @param (callable(TValue, TKey): bool)|null $callback
     * @return Collection
     */
    public function filter(callable $callback = null): Collection;
}
