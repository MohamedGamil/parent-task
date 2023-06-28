<?php

namespace App\Repositories\Concerns;

use App\Repositories\Types\JsonDataErrors;
use Illuminate\Support\Collection;

/**
 * Json Data Source Contract
 */
interface JsonDataSource extends DataSource
{
    /**
     * Query the json data
     *
     * @return Collection
     */
    public function query(): Collection;

    /**
     * Get JSON Error
     *
     * @return JsonDataErrors|null
     */
    public function getErrorMessage(): JsonDataErrors|null;
}
