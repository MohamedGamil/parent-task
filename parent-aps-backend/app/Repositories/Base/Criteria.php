<?php

namespace App\Repositories\Concerns;

use App\Repositories\Concerns\Criteria as ICriteria;
// use App\Repositories\Types\FilterCriteriaType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Filter Criteria Base Class
 */
abstract class Criteria implements ICriteria
{
    /**
     * JSON File Path
     */
    private $filePath;

    /**
     * Should cache data
     */
    private bool $cached;

    /**
     * Create a new filter criteria
     */
    public function __construct(
        // string $filePath,
        // bool $cached = false,
        // int $cacheDuration = 600,
        // bool $lazy = true,
    ) {
        // $this->lazy = $lazy;
        // $this->cached = $cached;
        // $this->cacheDuration = $cacheDuration;
        // $this->filePath = realpath($filePath);

        // if (false === $this->filePath) {
        //     throw new BadJsonDataSourceFile("JSON file does not exist at given path: '{$filePath}'");
        // }

        // if (true === $lazy && true === $cached) {
        //     throw new IncompatibleJsonDataSourceModes('JSON data source cached mode is not compatible with lazy mode.');
        // }
    }

    abstract public function apply(array $userInputs);
}
