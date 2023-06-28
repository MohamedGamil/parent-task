<?php

namespace App\Repositories\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Repository with data source contract
 */
interface WithDataSource
{
    /**
     * Set repository data source
     *
     * @param DataSource $dataSource
     * @return self
     */
    public function setDataSource(DataSource $dataSource);

    /**
     * Get data source
     *
     * @return DataSource
     */
    public function getDataSource(): DataSource;
}
