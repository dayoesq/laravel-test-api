<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;



class SellerScope implements Scope
{
    /**
     * Implicit biding of the seller resource to product.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->has('products');
    }
}

