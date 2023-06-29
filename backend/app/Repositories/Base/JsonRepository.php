<?php

namespace App\Repositories\Base;

use App\Repositories\Concerns\DataSource;
use App\Repositories\Concerns\JsonDataSource;
use App\Repositories\Concerns\JsonRepository as IJsonRepository;
use App\Repositories\Concerns\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Base JSON Repository
 *
 * @uses JsonRepository::$jsonFile
 */
abstract class JsonRepository implements IJsonRepository
{
    /**
     * JSON File Name
     */
    protected static $jsonFile;

    /**
     * Use lazy collections
     */
    protected static $lazy = true;

    /**
     * Should cache data
     */
    protected static $cached = false;

    /**
     * Cache duration
     */
    protected static $cacheDuration = 1200;

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
        $this->setDataSource(
            $dataSource
        );
    }

    public function query(): Collection|LazyCollection
    {
        return $this->dataSource->query();
    }

    public function all()
    {
        return $this->query()->all();
    }

    public function filter(callable $callback = null): Collection|LazyCollection
    {
        return $this->query()->filter(
            $callback
        );
    }

    public function filterBy(string $attribute, mixed $value): Collection|LazyCollection
    {
        return $this->filter(function($item) use ($attribute, $value) {
            return collect($item)->get($attribute) === $value;
        });
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
            'lazy' => static::$lazy,
        ];
    }
}
