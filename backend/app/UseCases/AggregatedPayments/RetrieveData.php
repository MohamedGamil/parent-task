<?php

namespace App\UseCases\AggregatedPayments;

use App\Exceptions\UseCaseException;
use App\UseCases\Base\UseCase;
use App\UseCases\Contracts\RetrieveDataInterface;
use App\Repositories\Contracts\PaymentsDataRepositoryInterface;
use Domain\Entities\AggregatedPayment;
use Domain\Types\AggregatedPayment as TAggregatedPayment;
use Domain\Types\Entities;
use Illuminate\Support\Collection;

/**
 * Retrieve data from payments repository and filter records
 */
final class RetrieveData extends UseCase implements RetrieveDataInterface
{
    /**
     * Allowed stauts code filter values
     */
    const ALLOWED_STATUS_CODE = [
        'authorised', 'decline', 'refunded'
    ];

    /**
     * Use case active query
     */
    private Collection $query;

    /**
     * User inputs
     */
    private Collection $inputs;

    /**
     * Filter callbacks
     */
    private array $callbacks;

    /**
     * Filtered source repository
     */
    private $only;

    public function __construct(
        private PaymentsDataRepositoryInterface $aggregator
    ) {}

    public function execute($inputs = [])
    {
        return $this->handleUserInputs($inputs)
            ->handleFilters()
            ->query()
            ->mapToEntities()
            ->combine();
    }

    private function query($repository = null)
    {
        $repository = $this->only ?? $repository;
        $this->query = $this->aggregator->query($repository);

        if (false === empty($this->callbacks)) {
            $callbacks = $this->callbacks;
            $stream = $this->query;
            $apply = fn($item, $index, $repo, $callback) => $callback($item, $index, $repo);

            foreach ($callbacks as $callback) {
                if (true === empty($repository)) {
                    foreach ($stream as $repo => $items) {
                        $stream[$repo] = $items->filter(fn($item, $idx) => $apply($item, $idx, $repo, $callback));
                    }

                    continue;
                }

                $stream = $stream->filter(fn($item, $idx) => $apply($item, $idx, $repository, $callback));
            }

            $this->query = collect(
                $stream->toArray()
            );
        }

        return $this;
    }

    private function handleUserInputs($inputs = [])
    {
        $this->inputs = collect($inputs);

        return $this;
    }

    private function handleFilters()
    {
        return $this->handleProviderFilter()
            ->handleStatusFilter()
            ->handleAmountRangeFilter()
            ->handleCurrencyFilter();
    }

    private function mapToEntities()
    {
        $provider = $this->only;
        $source = $this->query;
        $hasProviderFilter = false === empty($provider);

        $entityNameFromRepo = fn($repo) => $this->guessBaseEntityLabelFromRepository($repo);
        $initEntity = fn($name, $attrs) => $this->getEntityFromRepository($name, $attrs);

        $map = function($repo, $src) use ($initEntity) {
            return collect($src)->map(fn($item) => $initEntity($repo, $item));
        };

        if ($hasProviderFilter) {
            $this->query = collect(
                [$entityNameFromRepo($provider) => $map($provider, $source)]
            );

            return $this;
        }

        $source = $source
            ->map(fn($items, $repo) => $map($repo, $items))
            ->toArray();

        $src = [];

        foreach ($source as $repo => $data) {
            $src[
                $entityNameFromRepo($repo)
            ] = $data;
        }

        $this->query = collect($src);

        return $this;
    }

    private function filter($callback)
    {
        $this->callbacks[] = $callback;

        return $this;
    }

    private function combine()
    {
        return $this->query->flatten(1)->values();
    }

    /**
     * @return AggregatedPayment
     */
    private function getEntityFromRepository($repository, $attributes = [])
    {
        $entityNameFromRepo = fn($repo) => $this->guessBaseEntityLabelFromRepository($repo);

        $getEntity = fn($name) => Entities::fromName(
            $entityNameFromRepo($name)
        );

        $initEntity = fn($name, $attrs) => AggregatedPayment::fromEntity(
            $getEntity($name),
            (array) $attrs
        );

        return $initEntity($repository, $attributes);
    }

    private function guessBaseEntityLabelFromRepository($repository)
    {
        $class = class_basename($repository);

        return str_replace('Repository', '', $class);
    }

    private function guessRepositoryClassFromEntity($entity)
    {
        $repos = config('repositories.aggregated_payments_repositories', []);

        return collect($repos)
            ->filter(fn($item) => false !== strstr($item, $entity))
            ->first();
    }

    private function getSupportedRepositories()
    {
        $repos = config('repositories.aggregated_payments_repositories', []);

        return collect($repos)
            ->map(fn($item) => $this->guessBaseEntityLabelFromRepository($item))
            ->toArray();
    }

    private function handleProviderFilter()
    {
        $provider = $this->inputs->get('provider');
        $supported = $this->getSupportedRepositories();

        if (false === empty($provider) && in_array($provider, $supported, true)) {
            $this->only = $this->guessRepositoryClassFromEntity($provider);
        }

        return $this;
    }

    private function handleStatusFilter()
    {
        $status = $this->inputs->get('status');
        $allowed = static::ALLOWED_STATUS_CODE;

        if (empty($status)) {
            return $this;
        }

        if (false === in_array($status, $allowed, true)) {
            throw new UseCaseException("Invalid status code given: '{$status}'");
        }

        $entityStatus = fn($entity) => sprintf(
            '\Domain\Types\%sStatus',
            $entity
        );

        $entityName = fn($repo) => $this->guessBaseEntityLabelFromRepository($repo);
        $initEntityStatus = fn($code, $entity) => $entityStatus($entityName($entity))
            ::fromName($code);

        $this->filter(function($item, $index, $repository = null) use ($status, $initEntityStatus) {
            $entity = $this->getEntityFromRepository($repository, $item);
            $entityStatus = $initEntityStatus($status, $repository);
            $attr = $entity->getAttribute(
                TAggregatedPayment::STATUS_CODE->value
            );

            return $attr === $entityStatus->value;
        });

        return $this;
    }

    private function handleAmountRangeFilter()
    {
        $min = $this->inputs->get('balanceMin');
        $max = $this->inputs->get('balanceMax');

        if (empty($min) && empty($max)) {
            return $this;
        }

        $this->filter(function($item, $index, $repository = null) use ($min, $max) {
            $entity = $this->getEntityFromRepository($repository, $item);
            $attr = $entity->getAttribute(
                TAggregatedPayment::PARENT_AMOUNT->value
            );

            $min = max(intval($min ?? PHP_INT_MIN), PHP_INT_MIN);
            $max = min(intval($max ?? PHP_INT_MAX), PHP_INT_MAX);

            return $attr >= $min && $attr <= $max;
        });

        return $this;
    }

    private function handleCurrencyFilter()
    {
        $currency = $this->inputs->get('currency');

        if (empty($currency)) {
            return $this;
        }

        $this->filter(function($item, $index, $repository = null) use ($currency) {
            $entity = $this->getEntityFromRepository($repository, $item);
            $attr = $entity->getAttribute(
                TAggregatedPayment::CURRENCY->value
            );

            return $attr === $currency;
        });

        return $this;
    }
}
