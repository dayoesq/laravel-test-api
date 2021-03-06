<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the products by the buyer resource.
     *
     * @param Buyer $buyer
     * @return JsonResponse
     */
    public function index(Buyer $buyer): JsonResponse
    {
        $products = $buyer->transactions()->with('product')
            ->get()
            ->pluck('product');
        return $this->showAll($products);
    }
}
