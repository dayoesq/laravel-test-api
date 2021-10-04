<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the transactions on the buyer resource.
     *
     * @param Buyer $buyer
     * @return JsonResponse
     */
    public function index(Buyer $buyer): JsonResponse
    {
        $transactions = $buyer->transactions;
        return $this->showAll($transactions);
    }
}
