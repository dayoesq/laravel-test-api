<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @param Product $product
     * @return array
     */
    public function transform(Product $product): array
    {
        return [
            'identifier' => (int)$product->id,
            'title' => (string)$product->name,
            'details' => (string)$product->description,
            'stock' => (int)$product->quantity,
            'situation' => $product->status,
            'picture' => url("images/{$product->image}"),
            'seller' => (string)$product->seller_id,
            'creationDate' => (string)$product->created_at,
            'lastChanged' => (string)$product->updated_at,
            'deletedDate' => (string)isset($product->deleted_at) ? (string) $product->deleted_at : null
        ];
    }
}
