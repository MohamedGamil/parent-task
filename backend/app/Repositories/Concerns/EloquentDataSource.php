<?php

namespace App\Repositories\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Eloquent Data Source Contract
 */
interface EloquentDataSource extends DataSource
{
    /**
     * Query the eloquent model
     *
     * @return Builder
     */
    public function query(): Builder;
}
