<?php

namespace Tests\Unit;

use App\Repositories\Concerns\JsonRepository;
use App\Repositories\DataProviderXRepository;
use Tests\TestCase;

class JsonRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_json_repository_x_instance_of_json_repo(): void
    {
        /** @var DataProviderXRepository $repox */
        $repox = app()->make(DataProviderXRepository::class);

        $this->assertTrue(
            $repox instanceof JsonRepository
        );
    }
}
