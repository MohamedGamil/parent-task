<?php

namespace Tests\Unit;

use App\Repositories\Contracts\PaymentsDataRepositoryInterface;
use App\Repositories\DataProviderXRepository;
use App\Repositories\PaymentsDataAggregatorRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AggregatedPaymentsRepositoryTest extends TestCase
{
    public function test_repo_instance_of_payments_repo(): void
    {
        /** @var PaymentsDataAggregatorRepository $aggr */
        $aggr = app()->make(PaymentsDataRepositoryInterface::class);

        $this->assertTrue(
            $aggr instanceof PaymentsDataAggregatorRepository,
            "Payments repository interface should resolve to an instance of (PaymentsDataAggregatorRepository)"
        );
    }

    public function test_all_method(): void
    {
        /** @var PaymentsDataAggregatorRepository $aggr */
        $aggr = app()->make(PaymentsDataRepositoryInterface::class);

        $this->assertTrue(
            $aggr->all() instanceof Collection,
            "All method should return an instance of collection"
        );
    }

    public function test_all_method_count(): void
    {
        /** @var PaymentsDataAggregatorRepository $aggr */
        $aggr = app()->make(PaymentsDataRepositoryInterface::class);
        $all = $aggr->all();

        $this->assertCount(
            2,
            $all,
            "All method should return items with count of 2"
        );

        $this->assertArrayHasKey(
            DataProviderXRepository::class,
            $all
        );
    }

    public function test_all_method_with_only_filter_count(): void
    {
        /** @var PaymentsDataAggregatorRepository $aggr */
        $aggr = app()->make(PaymentsDataRepositoryInterface::class);
        $all = $aggr->only(DataProviderXRepository::class)->all();

        $this->assertCount(
            5,
            $all,
            "All method with whilte using only filter should return items with count of 5"
        );

        $this->assertArrayNotHasKey(
            DataProviderXRepository::class,
            $all
        );
    }
}
