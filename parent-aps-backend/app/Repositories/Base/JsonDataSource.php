<?php

namespace App\Repositories\Base;

use App\Exceptions\BadJsonDataSourceFile;
use App\Repositories\Concerns\JsonDataSource as IJsonDataSource;
use App\Repositories\Types\DataSourceType;
use App\Repositories\Types\JsonDataErrors;
use Illuminate\Support\Collection;
use JsonMachine\Items;

/**
 * JSON Data Source
 */
final class JsonDataSource implements IJsonDataSource
{
    /**
     * Defines data source type
     */
    const DATA_SOURCE_TYPE = DataSourceType::JSON;

    /**
     * Should cache data
     */
    private bool $cached;

    /**
     * Cache duration
     */
    private int $cacheDuration;

    /**
     * JSON File Path
     */
    private $filePath;

    /**
     * Create a new JSON Data Source
     */
    public function __construct(
        string $filePath,
        bool $cached = false,
        int $cacheDuration = 600,
    ) {
        $this->cached = $cached;
        $this->cacheDuration = $cacheDuration;
        $this->filePath = realpath($filePath);

        if (false === $this->filePath) {
            throw new BadJsonDataSourceFile("JSON file does not exist at given path: '{$filePath}'");
        }
    }

    public function getType(): DataSourceType
    {
        return static::DATA_SOURCE_TYPE;
    }

    public function query(): Collection
    {
        $query = fn() => collect(
            $this->getJsonFileAsArray()
        );

        if (true === $this->cached) {
            $cacheTag = sha1(
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

    private function getJsonFileAsArray(): array
    {
        $items = Items::fromFile(
            $this->getFilePath()
        );

        return iterator_to_array($items);
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
