<?php

namespace App\Models;


use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends User
{
    public string|\App\Transformers\UserTransformer $transformer = SellerTransformer::class;
    /**
     * Model booted constructor
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new SellerScope());
    }

    /**
     * Model booted constructor
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
