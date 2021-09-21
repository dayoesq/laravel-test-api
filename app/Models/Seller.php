<?php

namespace App;

use App\Models\Product;
use App\Models\User;


class Seller extends User
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
