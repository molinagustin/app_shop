@extends('layouts.app')

@section ('tittle', 'AlVenta | Detalles del Pedido')

@section ('body-class', 'profile-page sidebar-collapse')

@section('styles')
<style>
    .itemLista {
        border: 1px solid rgba(0, 0, 0, .125);
        border-right: 0;
        border-left: 0;
        border-top: 0;
    }
</style>
@endsection

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce2.jpg')}}')">
</div>

<div class="main main-raised">
    <div class="profile-content">
        <div class="container">
            <div class="section">

                <h3 class="title text-center">Resumen del pedido #{{$cart->id}}</h3>

                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="title text-center">Datos del Cliente</h4>
                        <ul class="list-group">
                            <li class="list-group-item itemLista">Nombre de Usuario: <b>{{ $cart->user->name }}</b></li>
                            <li class="list-group-item itemLista">Email: <b>{{ $cart->user->email }}</b></li>
                            <li class="list-group-item itemLista">Teléfono: <b>{{ $cart->user->phone }}</b></li>
                            <li class="list-group-item itemLista">Dirección: <b>{{ $cart->user->address }}</b></li>
                        </ul>
                    </div>

                    <div class="col-sm-6">
                        <h4 class="title text-center">Datos del Pedido</h4>
                        <ul class="list-group">
                            <li class="list-group-item itemLista">Fecha Pedido: <b>{{ \Carbon\Carbon::parse($cart->order_date)->format('d/m/Y H:i:s') }}</b></li>
                            <li class="list-group-item itemLista">Fecha Entrega: <b>{{ $cart->arrived_date ? \Carbon\Carbon::parse($cart->arrived_date)->format('d/m/Y H:i:s') : 'Sin Entregar' }}</b></li>
                            <li class="list-group-item itemLista">Última Modificación: <b>{{ \Carbon\Carbon::parse($cart->updated_at)->format('d/m/Y H:i:s') }}</b></li>
                            <li class="list-group-item itemLista">Estado: <b><span @switch($cart->status->status)
                                        @case('Pendiente')
                                        style="text-transform: uppercase;color:#e6b11a;"
                                        @break

                                        @case('Aprobado')
                                        style="text-transform: uppercase;color:#00c700;"
                                        @break

                                        @case('Cancelado')
                                        style="text-transform: uppercase;color:red;"
                                        @break

                                        @case('Finalizado')
                                        style="text-transform: uppercase;color:#007ec7;"
                                        @break

                                        @default
                                        style="text-transform: uppercase;"
                                        @endswitch>{{ $cart->status->status }}</span></b></li>
                            @if ($cart->status_id == 5 || $cart->payed)
                            <li class="list-group-item itemLista">Forma de Pago: <b>{{ $cart->payMethod->name }}</b></li>
                            <li class="list-group-item itemLista">Fecha de Pago: <b>{{ \Carbon\Carbon::parse($cart->pay_date)->format('d/m/Y H:i:s')}}</b></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <h4 class="title text-center">Datos de los Productos</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Imagen</th>
                            <th class="col-auto text-center">Nombre</th>
                            <th class="text-right">Precio</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Sub Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cart->details as $detail)
                        <tr>
                            <td class="text-center">
                                <img src="{{$detail->product->featured_image_url}}" width="50" height="50">
                            </td>

                            <td class="text-center">
                                <a href="{{ url('/products/'. $detail->product->id) }}" target="_blank">{{$detail->product->name}}</a>
                            </td>

                            <td class="text-right">&dollar; {{$detail->product->price}}</td>

                            <td class="text-center">{{ $detail->quantity }}</td>

                            <td class="text-center">&dollar; {{ $detail->quantity * $detail->product->price }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="text-right"><b>TOTAL A PAGAR</b></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td class="text-center"><b>$ {{ $cart->total }}</b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="title text-center">Observaciones</h5>
                <textarea class="form-control" rows="2" name="observation" placeholder="Observaciones" readonly>{{ ($cart->observations) ? $cart->observations : 'Sin observaciones' }}</textarea>

                <div class="text-center">
                    <a href="{{ route('orders') }}" class="btn btn-default text-center">Volver</a>

                    <div class="text-right">
                        <a href="/contact">¿Necesitas ayuda?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')

@endsection