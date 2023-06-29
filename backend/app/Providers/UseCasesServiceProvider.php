<?php

namespace App\Providers;

use App\Repositories\Contracts\PaymentsDataRepositoryInterface;
use App\UseCases\AggregatedPayments\RetrieveData;
use App\UseCases\Contracts\RetrieveDataInterface;
use Illuminate\Support\ServiceProvider;

class UseCasesServiceProvider extends ServiceProvider
{
    /**
     * Register repositories
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            RetrieveDataInterface::class,
            function($app) {
                $repo = $app->make(PaymentsDataRepositoryInterface::class);

                return new RetrieveData(
                    $repo
                );
            }
        );
    }
}
