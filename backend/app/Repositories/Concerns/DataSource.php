<?php

namespace App\Repositories\Concerns;

use App\Repositories\Types\DataSourceType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Data Source Contract
 */
interface DataSource
{
    /**
     * Get Data Source Type
     *
     * @return DataSourceType
     */
    public function getType(): DataSourceType;

    /**
     * Query the underlying data source
     *
     * @return Collection|LazyCollection|Builder
     */
    public function query(): Collection|LazyCollection|Builder;
}
