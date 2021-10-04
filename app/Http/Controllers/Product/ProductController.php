<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class ProductController extends ApiController
{
    /**
     * Display a listing of the product resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    /**
     * Display the specified product resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return $this->showOne($product);
    }

}
