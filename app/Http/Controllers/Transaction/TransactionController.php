<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;


class TransactionController extends ApiController
{
    /**
     * Display a listing of the transaction resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    /**
     * Display the specified transaction resource.
     *
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function show(Transaction $transaction): JsonResponse
    {
        return $this->showOne($transaction);
    }
}
