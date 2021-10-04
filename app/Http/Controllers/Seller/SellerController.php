<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;


class SellerController extends ApiController
{
    /**
     * Display a listing of the seller resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sellers = Seller::has('products')->get();
        return $this->showAll($sellers);
    }

    /**
     * Display the specified seller resource.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function show(Seller $seller): JsonResponse
    {
        return $this->showOne($seller);
    }

}
