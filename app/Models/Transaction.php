<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;

class Transaction extends Model
{
    protected $fillable = [
        'quantity',
        'product_id',
        'buyer_id'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
