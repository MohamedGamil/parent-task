<?php

namespace App\Providers;

use App\Repositories\PaymentsDataAggregatorRepository;
use App\Repositories\Base\JsonDataSource;
use App\Repositories\Contracts\PaymentsDataRepositoryInterface;
use App\Repositories\DataProviderXRepository;
use App\Repositories\DataProviderYRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Aggregated Payments Data Repositories
     */
    const AGGREGATED_PAYMENTS_REPOSITORIES = [
        DataProviderXRepository::class,
        DataProviderYRepository::class,
    ];

    /**
     * Payments Data Aggregator Repository Class & Interface
     */
    const AGGREGATOR_DATA_REPOSITORY_CLASS = PaymentsDataAggregatorRepository::class;
    const AGGREGATOR_DATA_REPOSITORY_INTERFACE = PaymentsDataRepositoryInterface::class;

    /**
     * JSON Data Source Class
     */
    const JSON_DATA_SRC_CLASS = JsonDataSource::class;

    /**
     * Register repositories
     *
     * @return void
     */
    public function register()
    {
        $repositories = $this->getAggregatedRepositories();

        $this->app->bind(
            ...$this->bindableJsonDataSource()
        );

        foreach($repositories as $class) {
            $this->app->bind(
                ...$this->bindableJsonRepository($class)
            );
        }

        $this->app->bind(
            ...$this->bindableAggregatorPaymentsRepository()
        );
    }

    private function bindableJsonDataSource()
    {
        $dataSourceClass = static::JSON_DATA_SRC_CLASS;

        return [
            $dataSourceClass,
            function ($app, array $config) use ($dataSourceClass) {
                $config = (Object) $config;
                $path = config('json.base_dir', '') . $config->file;

                if ('./' === substr($path, 0, 2)) {
                    $path = base_path($path);
                }

                return new $dataSourceClass(
                    $path,
                    $config->cached,
                    $config->duration,
                    $config->lazy,
                );
            }
        ];
    }

    private function bindableJsonRepository(string $class)
    {
        return [
            $class,
            function ($app) use ($class) {
                $config = $class::getJsonDataSourceConfig();

                return new $class(
                    $app->make(JsonDataSource::class, $config)
                );
            }
        ];
    }

    private function bindableAggregatorPaymentsRepository()
    {
        $contract = static::AGGREGATOR_DATA_REPOSITORY_INTERFACE;
        $class = static::AGGREGATOR_DATA_REPOSITORY_CLASS;
        $repositories = $this->getAggregatedRepositories();

        return [
            $contract,
            function ($app) use ($class, $repositories) {
                $repos = [];

                foreach ($repositories as $r) {
                    $repos[] = $app->make($r);
                }

                return new $class(...$repos);
            }
        ];
    }

    private function getAggregatedRepositories()
    {
        return config(
            'repositories.aggregated_payments_repositories',
            static::AGGREGATED_PAYMENTS_REPOSITORIES
        );
    }
}
