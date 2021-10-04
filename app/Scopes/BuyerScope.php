<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;


class BuyerScope implements Scope {
    /**
     * Implicit biding of the buyer resource to transaction.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->has('transactions');
    }
}
