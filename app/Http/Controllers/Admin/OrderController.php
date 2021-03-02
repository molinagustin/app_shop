<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Cart;
use App\CartStatus;

class OrderController extends Controller
{
    public function index()
    {
        $carts = Cart::whereIn('status_id', ['2', '3', '4', '5'])->orderBy('status_id', 'asc')->orderBy('order_date', "desc")->paginate(10);
        return view('admin.orders.index')->with(compact('carts'));
    }

    public function edit(Cart $order)
    {
        $statuses = CartStatus::whereIn('id', ['2', '3', '4', '5'])->get();
        return view('admin.orders.edit')->with(compact('order', 'statuses'));
    }

    public function update(Request $request, Cart $order)
    {
        $order->status_id = $request->input('status_id');

        if($request->status_id == 5)
            $order->arrived_date = $request->arrived_date;

        $order->observations = $request->observation;
        $order->save();        

        //Por medio de una variable de sesion flash enviamos una notificacion
        $notification = 'El pedido fue modificado correctamente.';
        return back()->with(compact('notification'));
    }
}
