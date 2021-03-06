<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the buyers on the category resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function index(Category $category): JsonResponse
    {
        $buyers = $category->products()
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
