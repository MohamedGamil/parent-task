<?php

namespace App\Repositories\Concerns;

use App\Repositories\Types\JsonDataErrors;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Json Data Source Contract
 */
interface JsonDataSource extends DataSource
{
    /**
     * Query the json data
     *
     * @return Collection|LazyCollection
     */
    public function query(): Collection|LazyCollection;

    /**
     * Get JSON Error
     *
     * @return JsonDataErrors|null
     */
    public function getErrorMessage(): JsonDataErrors|null;
}
