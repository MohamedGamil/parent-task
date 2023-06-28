<?php

namespace App\Repositories\Base;

use App\Repositories\Concerns\DataSource;
use App\Repositories\Concerns\JsonDataSource;
use App\Repositories\Concerns\JsonRepository as IJsonRepository;
use App\Repositories\Concerns\Repository;
use Illuminate\Support\Collection;

/**
 * Base JSON Repository
 */
abstract class JsonRepository implements IJsonRepository
{
    /**
     * Should cache data
     */
    protected static bool $cached = false;

    /**
     * Cache duration
     */
    protected static int $cacheDuration = 1200;

    /**
     * JSON File Name
     */
    protected static $jsonFile;

    /**
     * Data source instance
     */
    protected JsonDataSource $dataSource;

    /**
     * Create a new JSON Repository
     */
    public function __construct(
        JsonDataSource $dataSource
    ) {
        $this->setDataSource($dataSource);
    }

    public function query(): Collection
    {
        return $this->dataSource->query();
    }

    public function all()
    {
        return $this->query()->all();
    }

    public function filter(callable $callback = null): Collection
    {
        return $this->query()->filter($callback);
    }

    public function setDataSource(DataSource $dataSource): Repository
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    public function getDataSource(): DataSource
    {
        return $this->dataSource;
    }

    public static function getJsonDataSourceConfig(): array
    {
        return [
            'file' => static::$jsonFile,
            'cached' => static::$cached,
            'duration' => static::$cacheDuration,
        ];
    }
}
