<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;


class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the transactions on the seller resource.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function index(Seller $seller): JsonResponse
    {
        $transactions = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();
        return $this->showAll($transactions);
    }
}
