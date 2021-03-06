<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;


class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the categories on the seller resource.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function index(Seller $seller): JsonResponse
    {
        $categories = $seller->products()
            ->whereHas('categories')
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values();
        return $this->showAll($categories);
    }

}
