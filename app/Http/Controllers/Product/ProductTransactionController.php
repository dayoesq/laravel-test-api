<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class ProductTransactionController extends ApiController
{
    /**
     * Display a listing of the transaction on the product resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function index(Product $product): JsonResponse
    {
        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }

}
