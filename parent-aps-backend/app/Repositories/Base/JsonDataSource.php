<?php

namespace App\Repositories\Base;

use App\Exceptions\BadJsonDataSourceFile;
use App\Exceptions\IncompatibleJsonDataSourceModes;
use App\Repositories\Concerns\JsonDataSource as IJsonDataSource;
use App\Repositories\Types\DataSourceType;
use App\Repositories\Types\JsonDataErrors;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use JsonMachine\Items;
use Generator;

/**
 * JSON Data Source
 */
final class JsonDataSource implements IJsonDataSource
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
     * Cache duration
     */
    private int $cacheDuration;

    /**
     * Use lazy collections
     */
    private bool $lazy;

    /**
     * Create a new JSON Data Source
     */
    public function __construct(
        string $filePath,
        bool $cached = false,
        int $cacheDuration = 600,
        bool $lazy = true,
    ) {
        $this->lazy = $lazy;
        $this->cached = $cached;
        $this->cacheDuration = $cacheDuration;
        $this->filePath = realpath($filePath);

        if (false === $this->filePath) {
            throw new BadJsonDataSourceFile("JSON file does not exist at given path: '{$filePath}'");
        }

        if (true === $lazy && true === $cached) {
            throw new IncompatibleJsonDataSourceModes('JSON data source cached mode is not compatible with lazy mode.');
        }
    }

    public function getType(): DataSourceType
    {
        return DataSourceType::JSON;
    }

    public function query(): Collection|LazyCollection
    {
        $query = fn() => true === $this->lazy
            ? LazyCollection::make(fn() => $this->getJsonStream())
            : Collection::make(
                $this->getJsonStream()
            );

        if (true === $this->cached) {
            $cacheTag = md5(
                $this->getFilePath()
            );

            return cache()->remember(
                $cacheTag,
                $this->cacheDuration,
                $query
            );
        }

        return $query();
    }

    private function getJsonStream(): Generator
    {
        $items = Items::fromFile(
            $this->getFilePath()
        );

        return $items->getIterator();
    }

    private function getFilePath()
    {
        return $this->filePath;
    }

    public function getErrorMessage(): JsonDataErrors|null
    {
        $error = json_last_error();
        $cases = [
            JSON_ERROR_STATE_MISMATCH => JsonDataErrors::JSON_ERROR_STATE_MISMATCH,
            JSON_ERROR_CTRL_CHAR => JsonDataErrors::JSON_ERROR_CTRL_CHAR,
            JSON_ERROR_SYNTAX => JsonDataErrors::JSON_ERROR_SYNTAX,
            JSON_ERROR_DEPTH => JsonDataErrors::JSON_ERROR_DEPTH,
            JSON_ERROR_UTF8 => JsonDataErrors::JSON_ERROR_UTF8,
        ];

        return isset($cases[$error])
            ? $cases[$error]
            : null;
    }
}
