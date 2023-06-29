<?php

namespace App\Repositories\Contracts;

use App\Repositories\Concerns\JsonRepository;
use App\Repositories\Concerns\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Payments Data Aggregator Repository Interface
 */
interface PaymentsDataRepositoryInterface extends Repository
{
    /**
     * Specify a data repository source
     *
     * @param string $repository Repository class
     * @return self
     */
    public function only($repository = null);

    /**
     * Specify a data repository source
     *
     * @param (callable(TValue, TKey, JsonRepository): bool)|null $callback
     * @return Collection|LazyCollection
     */
    public function filter($callback);

    /**
     * Sets data source in internal repository pointer
     *
     * @param Collection|LazyCollection $source
     * @return self
     */
    public function setSource($source);
}
