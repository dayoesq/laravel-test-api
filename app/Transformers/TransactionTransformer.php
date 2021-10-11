<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
     * @param Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction): array
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => (string)$transaction->quantity,
            'buyer' => (string)$transaction->buyer_id,
            'product' => (string)$transaction->product_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChanged' => (string)$transaction->updated_at,
            'deletedDate' => (string)isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null
        ];
    }

    /**
     * Returns the original attributes on transaction.
     *
     * @param string $index
     * @return string|null
     */
    public static function originalAttribute(string $index): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'creationDate' => 'created_at',
            'lastChanged' => 'updated_at',
            'deletedDate' => 'deleted_at'
        ];
        return $attributes[$index] ?? null;
    }
}
