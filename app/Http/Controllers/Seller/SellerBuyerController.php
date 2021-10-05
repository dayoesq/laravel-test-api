<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;


class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the buyers on the seller resource.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function index(Seller $seller): JsonResponse
    {
        $buyers = $seller->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();
        return $this->showAll($buyers);
    }

}
