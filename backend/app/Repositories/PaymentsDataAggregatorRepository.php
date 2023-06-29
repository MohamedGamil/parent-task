<?php

namespace App\Repositories;

use App\Repositories\Concerns\JsonRepository;
use App\Repositories\Contracts\PaymentsDataRepositoryInterface;

/**
 * Payments Data Aggregator Repository
 */
final class PaymentsDataAggregatorRepository implements PaymentsDataRepositoryInterface
{
    /**
     * Aggregated data repositories
     *
     * @param JsonRepository[] $repositories
     */
    protected array $repositories = [];

    /**
     * Filters data by a specific provider
     */
    protected string $only = '';

    private $source;

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

        if (is_array($source)) {
            $sources = [];

            foreach ($source as $class => $src) {
                $sources[$class] = $src->all();
            }

            return collect($sources);
        }

        return collect(
            $source->all()
        );
    }

    public function query($repository = null)
    {
        $source = $this->selectSources($repository);

        if (is_array($source)) {
            $sources = [];

            foreach ($source as $class => $src) {
                $sources[$class] = $src->query();
            }

            return collect($sources);
        }

        return collect(
            $source->query()
        );
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

    /**
     * Query and filter using a callback
     *
     * @param callable $callback Filter callback
     * @return Collection|LazyCollection
     */
    public function filter($callback)
    {
        $source = $this->selectSources();

        if (is_array($source)) {
            return collect($source)
                ->map(fn($repo) => $repo->filter(fn($item, $idx) => $callback(
                    $item, $idx, $repo
                )));
        }

        return $source->filter(fn($item, $idx) => $callback($item, $idx, $source));
    }

    public function setSource($source)
    {
        $this->source = $source;

        return $this;
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

        if (false === empty($this->source)) {
            $src = $this->source;

            $this->queryCleanup();

            return $src;
        }

        $this->queryCleanup();

        if (false === empty($repository) && isset($this->repositories[$repository])) {
            return $this->source = $this->repositories[$repository];
        }

        foreach($this->repositories as $class => $repo) {
            if (false === empty($only) && $class !== $only) {
                continue;
            }

            $sources[$class] = $repo;
        }

        if (false === empty($only) && 1 === count($sources)) {
            return $this->source = reset($sources);
        }

        return $this->source = $sources;
    }

    private function queryCleanup()
    {
        $this->only = '';
        $this->source = null;
    }
}

