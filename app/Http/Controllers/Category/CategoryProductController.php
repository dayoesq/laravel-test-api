<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;


class CategoryProductController extends ApiController
{
    /**
     * Display a listing of the product on category resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function index(Category $category): JsonResponse
    {
        $products = $category->products;
        return $this->showAll($products);
    }
}
