<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
    /**
     * Model booted constructor
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new BuyerScope());
    }

    /**
     * Model booted constructor
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
