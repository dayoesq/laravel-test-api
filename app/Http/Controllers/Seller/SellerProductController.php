<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the products on the seller resource.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function index(Seller $seller): JsonResponse
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * Store a newly created product resource in storage.
     *
     * @param Request $request
     * @param User $seller
     * @return JsonResponse
     */
    public function store(Request $request, User $seller): JsonResponse
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ];
        $request->validate($rules);
        $data = $request->all();
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->file('image')->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);
        return $this->showOne($product, 201);
    }

    /**
     * Update the specified product resource by seller.
     *
     * @param Request $request
     * @param Seller $seller
     * @param Product $product
     * @return JsonResponse
     */
    public function update(Request $request, Seller $seller, Product $product): JsonResponse
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'status' => 'in' . Product::UNAVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT,
            'image' => 'image'
        ];
        $request->validate($rules);
        $this->checkSeller($seller, $product);
        $product->fill($request->only([
            'name',
            'description',
            'quantity'
        ]));
        if($request->status) {
            $product->status = $request->status;
            if($product->isAvailable() && $product->categories()->count() < 1) {
                return $this->errorResponse('An active product must have at least one category', 409);
            }
        }
        if($product->isClean()) {
            return $this->errorResponse('There is nothing to update', 422);
        }
        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Seller $seller
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Seller $seller, Product $product): JsonResponse
    {
        $this->checkSeller($seller, $product);
        $product->delete();
        return $this->showOne($product);
    }

    /**
     * Check if seller can update product.
     *
     * @param Seller $seller
     * @param Product $product
     * @return void
     */
    protected function checkSeller(Seller $seller, Product $product)
    {
        if($seller->id !== $product->seller_id) {
           throw new HttpException(422, 'Only the seller of the product can perform this operation');
        }
    }

}
