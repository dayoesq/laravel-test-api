<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the categories on the product resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function index(Product $product): JsonResponse
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    /**
     * Update the specified category on product resource in storage.
     *
     * @param Product $product
     * @param Category $category
     * @return JsonResponse
     */
    public function update(Product $product, Category $category): JsonResponse
    {
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Product $product, Category $category): JsonResponse
    {
        $category = $product->categories()->findOrFail($category->id);
        $product->categories()->detach($category);
        return $this->showAll($product->categories);
    }
}
