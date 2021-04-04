<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function details()
    {
        return $this->hasMany(CartDetail::class);
    }

    public function status()
    {
        return $this->belongsTo(CartStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payMethod()
    {
        return $this->belongsTo(PayMethod::class);
    }

    //Accesor que calcula el precio total a pagar de un carro de compras ya siendo una orden
    public function getTotalAttribute()
    {
        $total = 0;
        foreach($this->details as $detail)
        {
            $total += $detail->quantity * $detail->product->price;
        };       
        //Devuelvo el total
        return $total;
    }
}
