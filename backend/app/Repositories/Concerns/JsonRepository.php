<?php

namespace App\Repositories\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Json Repository Contract
 */
interface JsonRepository extends Repository, WithDataSource
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
     * @return Collection|LazyCollection
     */
    public function query(): Collection|LazyCollection;

    /**
     * Filter items using a callback
     *
     * @param (callable(TValue, TKey): bool)|null $callback
     * @return Collection|LazyCollection
     */
    public function filter(callable $callback = null): Collection|LazyCollection;
}
