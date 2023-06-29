<?php

namespace App\Http\Controllers;

use App\UseCases\Contracts\RetrieveDataInterface;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function users(
        Request $request,
        RetrieveDataInterface $useCase
    ) {
        $transactions = $useCase->execute(
            $request->all()
        );

        return TransactionResource::collection($transactions);
    }
}
