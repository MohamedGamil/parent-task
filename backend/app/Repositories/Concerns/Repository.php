<?php

namespace App\Repositories\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Repository Contract
 */
interface Repository
{
    /**
     * Query all repository data
     *
     * @return array|Collection|LazyCollection
     */
    public function all();

    /**
     * Start a new query
     *
     * @return array|Collection|LazyCollection|Builder
     */
    public function query();
}
