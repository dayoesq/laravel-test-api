<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductBuyerTransactionController extends ApiController
{
    /**
     * Store a newly created product resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param User $buyer
     * @return JsonResponse
     */
    public function store(Request $request, Product $product, User $buyer): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if($buyer->id === $product->seller_id) {
            return $this->errorResponse('The buyer must be different from seller', 409);
        }

        if(!$buyer->isVerified()) {
            return $this->errorResponse('The buyer must be a verified user', 403);
        }

        if(!$product->seller->isVerified()) {
            return $this->errorResponse('The seller must be a verified user', 403);
        }

        if(!$product->isAvailable()) {
            return $this->errorResponse('The product is not available', 404);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);
            return $this->showOne($transaction, 201);
        });
    }

}
