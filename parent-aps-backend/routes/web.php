<?php

use App\Repositories\DataProviderXRepository;
use App\Repositories\DataProviderYRepository;
use App\Repositories\PaymentsDataAggregatorRepository;
use Domain\Entities\AggregatedPayment;
use Domain\Entities\DataProviderX;
use Domain\Entities\DataProviderY;
use Domain\Types\Entities;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (
    DataProviderXRepository $repoX,
    DataProviderYRepository $repoY,
    PaymentsDataAggregatorRepository $aggregator,
) {
    $repox = $repoX->all();
    $repoy = $repoY->all();

    $aggr1 = $aggregator
        ->only(DataProviderXRepository::class)
        ->all();

    $aggr2 = $aggregator
        ->only(DataProviderYRepository::class)
        ->query()
        ->toArray();

    $aggr1Exp = collect($aggr1)->map(fn($item) => DataProviderX::fromArray($item));

    $aggr2Exp1 = collect($aggr2)->map(fn($item) => DataProviderY::fromArray($item));

    $aggr2Exp2 = collect($aggr2)
        ->map(fn($item) => AggregatedPayment::fromEntity(
            Entities::DATA_PROVIDER_Y,
            (array) $item
        ));

    dd(
        (Object) compact('repox', 'repoy', 'aggr1', 'aggr2', 'aggr1Exp', 'aggr2Exp1', 'aggr2Exp2')
    );

    // return view('welcome');
});
