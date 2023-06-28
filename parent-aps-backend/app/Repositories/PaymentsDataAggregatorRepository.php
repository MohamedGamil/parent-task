<?php

namespace App\Repositories;

use App\Repositories\Concerns\Criteria;
use App\Repositories\Concerns\JsonRepository;
use App\Repositories\Concerns\Repository;

/**
 * Payments Data Aggregator Repository
 */
final class PaymentsDataAggregatorRepository implements Repository
{
    /**
     * Aggregated data repositories
     *
     * @param JsonRepository[] $repositories
     */
    protected array $repositories = [];

    /**
     * Filters criteria instances
     *
     * @var Criteria[] $filters
     */
    protected array $filters = [];

    /**
     * Filters data by a specific provider
     */
    protected string $only = '';

    /**
     * Create a new Aggregated Data Repository
     */
    public function __construct(JsonRepository ...$repositories)
    {
        $this->setRepositories(...$repositories);
    }

    public function all($repository = null)
    {
        $source = $this->selectSources($repository);

        $this->cleanup();

        if (is_array($source)) {
            $sources = [];

            foreach ($source as $class => $src) {
                $sources[$class] = $src->all();
            }

            return $sources;
        }

        return $source->all();
    }

    public function query($repository = null)
    {
        $source = $this->selectSources($repository);

        $this->cleanup();

        if (is_array($source)) {
            $sources = [];

            foreach ($source as $class => $src) {
                $sources[$class] = $src->query();
            }

            return $sources;
        }

        return $source->query();
    }

    /**
     * Filter by a specific type of repository
     *
     * @param string $repository Repository class name. Example: `DataProviderYRepository::class`
     * @return self
     */
    public function only($repository = null)
    {
        $this->only = $repository;

        return $this;
    }

    public function addFilter(Criteria $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    public function applyFilters(array $filters = [])
    {
        if (false === empty($filters)) {
            foreach($filters as $filter) {
                $this->addFilter($filter);
            }
        }

        $this->executeFilters();
    }

    /**
     * Set JSON repositories
     */
    private function setRepositories(JsonRepository ...$repositories)
    {
        $this->repositories = [];

        foreach($repositories as $repo) {
            $name = get_class($repo);
            $this->repositories[$name] = $repo;
        }

        return $this;
    }

    /**
     * Select and filter data repositories
     *
     * @param string $repository
     * @return JsonRepository[]|JsonRepository
     */
    private function selectSources($repository = null)
    {
        $only = $this->only;
        $sources = [];

        if (false === empty($repository) && isset($this->repositories[$repository])) {
            return $this->repositories[$repository];
        }

        foreach($this->repositories as $class => $repo) {
            if (false === empty($only) && $class !== $only) {
                continue;
            }

            $sources[$class] = $repo;
        }

        if (false === empty($only) && 1 === count($sources)) {
            return reset($sources);
        }

        return $sources;
    }

    private function executeFilters()
    {
        $filters = $this->filters;

        foreach($filters as $filter) {
            // TODO:
        }
    }

    private function cleanup()
    {
        $this->only = '';
    }
}
