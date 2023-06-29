<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\UseCases\AggregatedPayments\RetrieveData;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function users(
        Request $request,
        RetrieveData $useCase
    ) {
        $transactions = $useCase->execute(
            $request->all()
        );

        return TransactionResource::collection($transactions);
    }
}
