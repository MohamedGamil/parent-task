<?php

namespace App\Repositories\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Filter Criteria Contract
 */
interface Criteria
{
    /**
     * Apply filter criteria
     *
     * @param array $userInputs
     * @return Collection|LazyCollection|Builder
     */
    public function apply(array $userInputs);
}
