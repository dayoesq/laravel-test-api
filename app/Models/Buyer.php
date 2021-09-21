<?php

namespace App;


use Illuminate\Database\Eloquent\Model\User;
use App\Transaction;

class Buyer extends User
{
    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }
}
