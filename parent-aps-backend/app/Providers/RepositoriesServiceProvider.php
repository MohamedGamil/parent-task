<?php

namespace App\Providers;

use App\Repositories\Base\JsonDataSource;
use App\Repositories\DataProviderXRepository;
use App\Repositories\DataProviderYRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
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
        $this->app->bind(
            ...$this->bindableJsonDataSource()
        );

        $this->app->bind(
            ...$this->bindableRepository(DataProviderXRepository::class)
        );

        $this->app->bind(
            ...$this->bindableRepository(DataProviderYRepository::class)
        );
    }

    private function bindableJsonDataSource()
    {
        $dataSourceClass = static::JSON_DATA_SRC_CLASS;

        return [
            $dataSourceClass,
            function ($app, $config) use ($dataSourceClass) {
                $config = (Object) $config;
                $path = config('json.base_dir', '') . $config->file;

                if ('./' === substr($path, 0, 2)) {
                    $path = base_path($path);
                }

                return new $dataSourceClass(
                    $path,
                    $config->cached,
                    $config->duration
                );
            }
        ];
    }

    private function bindableRepository(string $class)
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
}
