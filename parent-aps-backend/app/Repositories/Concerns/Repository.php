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
     * @return Collection
     */
    public function all();

    /**
     * Start a new query
     *
     * @return Collection|Builder
     */
    public function query(): Collection|Builder;

    /**
     * Set repository data source
     *
     * @param DataSource $dataSource
     * @return self
     */
    public function setDataSource(DataSource $dataSource): self;

    /**
     * Get data source
     *
     * @return DataSource
     */
    public function getDataSource(): DataSource;
}
