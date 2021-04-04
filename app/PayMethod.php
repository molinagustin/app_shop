<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
