<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Aggregated Payments Data Repositories
    |--------------------------------------------------------------------------
    |
    | This option controls the supported data repositories which are used to
    | fetch and filter data by the main payments aggregator repository.
    |
    */

    'aggregated_payments_repositories' => [
        \App\Repositories\DataProviderXRepository::class,
        \App\Repositories\DataProviderYRepository::class,
    ],
];
