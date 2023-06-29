<?php

namespace App\Repositories\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Json Repository Contract
 */
interface EloquentRepository extends Repository
{
    /**
     * Start a new query
     *
     * @return Builder
     */
    public function query(): Builder;
}
