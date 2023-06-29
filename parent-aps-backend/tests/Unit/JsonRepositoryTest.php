<?php

namespace Tests\Unit;

use App\Repositories\Concerns\JsonRepository;
use App\Repositories\DataProviderXRepository;
use Tests\TestCase;

class JsonRepositoryTest extends TestCase
{
    public function test_json_repo_instance_of_json_repo(): void
    {
        /** @var DataProviderXRepository $repox */
        $repox = app()->make(DataProviderXRepository::class);

        $this->assertTrue(
            $repox instanceof JsonRepository
        );
    }

    public function test_json_repo_query_data(): void
    {
        /** @var DataProviderXRepository $repox */
        $repox = app()->make(DataProviderXRepository::class);

        $this->assertGreaterThan(
            0,
            $repox->query()->count(),
            "DataProviderX repository all method should return records."
        );
    }
}
