@extends('layouts.app')

@section ('tittle', 'AlVenta | Dashboard')

@section ('body-class', 'profile-page sidebar-collapse')

@section ('cssFiles')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<!-- <link rel="stylesheet" href="{{ url('css\adminlte.min.css') }}"> -->

<style>
    .small-box:hover .icon>i,
    .small-box:hover .icon>i.fa,
    .small-box:hover .icon>i.fab,
    .small-box:hover .icon>i.fad,
    .small-box:hover .icon>i.fal,
    .small-box:hover .icon>i.far,
    .small-box:hover .icon>i.fas,
    .small-box:hover .icon>i.ion {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce.jpg')}}')">

</div>

<div class="main main-raised">


    <div class="container">

        <div class="section ">
            <h2 class="title text-center">Dashboard</h2>

            @if (session('notification'))
            <div class="alert alert-success" role="alert">
                {{ session('notification') }}
            </div>
            @endif

            <ul class="nav nav-pills nav-pills-success nav-pills-icons" role="tablist">
                <li class="nav-item">
                    <a @if (Request::url()==route('dashboard')) class='nav-link active' @else class='nav-link' @endif href="{{ url('/home/dashboard') }}" role="tab">
                        <i class="material-icons">dashboard</i>
                        Resumen
                    </a>
                </li>
                <li class="nav-item">

                    <a @if (Request::url()==route('cart')) class='nav-link active' @else class='nav-link' @endif href="{{ url('/home/cart') }}" role="tab">

                        <i class="material-icons">shopping_cart</i>
                        Carro de Compras
                    </a>

                </li>
                <li class="nav-item">
                    <a @if (Request::url()==route('orders')) class='nav-link active' @else class='nav-link' @endif href="{{ url('/home/orders') }}" role="tab">

                        <i class="material-icons">list</i>
                        Pedidos Realizados
                    </a>
                </li>
                <li class="nav-item">
                    <a @if (Request::url()==route('settings')) class='nav-link active' @else class='nav-link' @endif href="{{ url('/home/settings') }}" role="tab">
                        <i class="material-icons">settings</i>
                        Configuraciones
                    </a>
                </li>
            </ul>
            <div class="tab-content tab-space">
                <div @if (Request::url()==route('dashboard')) class='tab-pane active' @else class='tab-pane' @endif id="{{ url('/home/dashboard') }}" style="padding-top: 30px;">
                    <div class="row">

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info" style="border-radius: .25rem;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);display: block;margin-bottom: 20px;position: relative;background-color: #17a2b8!important;">
                                <div class="inner" style="padding: 10px;">
                                    <h3 style="z-index: 5;font-weight: 700;margin: 0 0 10px;padding: 0;white-space: nowrap;color:white;">{{ $totalOrders }}</h3>
                                    <p style="z-index: 5;font-size: 1rem;margin-top: 0;margin-bottom: 1rem;margin: 0 0 10px;color:white;">{{ $totalOrders != 1 ? 'Pedidos Realizados' : 'Pedido Realizado'}}</p>
                                </div>
                                <div class="icon" style="color: rgba(0,0,0,.15);z-index: 0;">
                                    <i class="ion ion-bag" style="font-size: 70px;top: 10px; position: absolute;right: 15px;transition: transform .3s linear;"></i>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: rgba(0,0,0,.1);color: #fff!important;display: block;padding: 3px 0;position: relative;text-align: center;text-decoration: none;z-index: 10;">Más Información <i class="material-icons" style="font-family: 'Material Icons';font-weight: normal;font-style: normal;font-size: 24px;line-height: 1;letter-spacing: normal;text-transform: none;display: inline-block;white-space: nowrap;word-wrap: normal;direction: ltr;    -webkit-font-smoothing: antialiased;vertical-align: middle;">arrow_forward</i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success" style="border-radius: .25rem;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);display: block;margin-bottom: 20px;position: relative;background-color: #28a745!important;">
                                <div class="inner" style="padding: 10px;">
                                    <h3 style="z-index: 5;font-weight: 700;margin: 0 0 10px;padding: 0;white-space: nowrap;color:white;">$ {{ $moneySpent }}</h3>
                                    <p style="z-index: 5;font-size: 1rem;margin-top: 0;margin-bottom: 1rem;margin: 0 0 10px;color:white;">Dinero Gastado</p>
                                </div>
                                <div class="icon" style="color: rgba(0,0,0,.15);z-index: 0;">
                                    <i class="ion ion-cash" style="font-size: 70px;top: 10px; position: absolute;right: 15px;transition: transform .3s linear;"></i>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: rgba(0,0,0,.1);color: #fff!important;display: block;padding: 3px 0;position: relative;text-align: center;text-decoration: none;z-index: 10;">Más Información <i class="material-icons" style="font-family: 'Material Icons';font-weight: normal;font-style: normal;font-size: 24px;line-height: 1;letter-spacing: normal;text-transform: none;display: inline-block;white-space: nowrap;word-wrap: normal;direction: ltr;    -webkit-font-smoothing: antialiased;vertical-align: middle;">arrow_forward</i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning" style="border-radius: .25rem;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);display: block;margin-bottom: 20px;position: relative;background-color: #ffc107!important;">
                                <div class="inner" style="padding: 10px;">
                                    <h3 style="z-index: 5;font-weight: 700;margin: 0 0 10px;padding: 0;white-space: nowrap;color:white;">44</h3>
                                    <p style="z-index: 5;font-size: 1rem;margin-top: 0;margin-bottom: 1rem;margin: 0 0 10px;color:white;">Productos Compartidos</p>
                                </div>
                                <div class="icon" style="color: rgba(0,0,0,.15);z-index: 0;">
                                    <i class="ion ion-android-share-alt" style="font-size: 70px;top: 10px; position: absolute;right: 15px;transition: transform .3s linear;"></i>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: rgba(0,0,0,.1);color: #fff!important;display: block;padding: 3px 0;position: relative;text-align: center;text-decoration: none;z-index: 10;">Más Información <i class="material-icons" style="font-family: 'Material Icons';font-weight: normal;font-style: normal;font-size: 24px;line-height: 1;letter-spacing: normal;text-transform: none;display: inline-block;white-space: nowrap;word-wrap: normal;direction: ltr;    -webkit-font-smoothing: antialiased;vertical-align: middle;">arrow_forward</i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger" style="border-radius: .25rem;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);display: block;margin-bottom: 20px;position: relative;background-color: #dc3545!important;">
                                <div class="inner" style="padding: 10px;">
                                    <h3 style="z-index: 5;font-weight: 700;margin: 0 0 10px;padding: 0;white-space: nowrap;color:white;">3</h3>
                                    <p style="z-index: 5;font-size: 1rem;margin-top: 0;margin-bottom: 1rem;margin: 0 0 10px;color:white;">Configuraciones de Seguridad Faltanes</p>
                                </div>
                                <div class="icon" style="color: rgba(0,0,0,.15);z-index: 0;">
                                    <i class="ion ion-android-settings" style="font-size: 70px;top: 10px; position: absolute;right: 15px;transition: transform .3s linear;"></i>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: rgba(0,0,0,.1);color: #fff!important;display: block;padding: 3px 0;position: relative;text-align: center;text-decoration: none;z-index: 10;">Más Información <i class="material-icons" style="font-family: 'Material Icons';font-weight: normal;font-style: normal;font-size: 24px;line-height: 1;letter-spacing: normal;text-transform: none;display: inline-block;white-space: nowrap;word-wrap: normal;direction: ltr;    -webkit-font-smoothing: antialiased;vertical-align: middle;">arrow_forward</i></a>
                            </div>
                        </div>

                    </div>
                </div>

                <div @if (Request::url()==route('cart')) class='tab-pane active' @else class='tab-pane' @endif id="{{ url('/home/cart') }}">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        <ul>
                            {{ session('error') }}
                        </ul>
                    </div>
                    @endif
                    @if (session('cancelled'))
                    <div class="alert alert-warning">
                        <ul>
                            {{ session('cancelled') }}
                        </ul>
                    </div>
                    @endif
                    <livewire:cart-table />
                </div>

                <div @if (Request::url()==route('orders')) class='tab-pane active' @else class='tab-pane' @endif id="{{ url('/home/orders') }}">
                    <h3 class="title">Compras</h3>

                    <div class="row" style="text-align: -webkit-center;">
                        @foreach($carts as $cart)
                        @foreach($cart->details as $detail)
                        <div class="panel panel-default">
                            <div class="col-md-4">
                                <div class="card" style="width: 28rem; margin-top:30px;">
                                    <img class="card-img-top" src="{{ $detail->product->featured_image_url }}" alt="Imagen de Producto Comprado" height="400px">
                                    <div class="card-body text-center" style="min-height: 150px;">
                                        <h5 class="card-title">{{ $detail->product->name }}</h5>
                                        <p class="card-text">{{ $detail->product->description }}</p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <li class="list-group-item">N° de Orden:</li>
                                                <li class="list-group-item">Cantidad Comprada:</li>
                                                <li class="list-group-item">Precio por Unidad:</li>
                                                <li class="list-group-item">Fecha de Pedido:</li>
                                                <li class="list-group-item">Última Actualización:</li>
                                                <li class="list-group-item">Estado:</li>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <b>
                                                    <li class="list-group-item">{{ $cart->id }}</li>
                                                    <li class="list-group-item">{{ $detail->quantity }} {{ $detail->quantity > 1 ? 'Unidades' : 'Unidad' }}</li>
                                                    <li class="list-group-item">$ {{ $detail->product->price }}</li>
                                                    <li class="list-group-item">{{ \Carbon\Carbon::parse($cart->order_date)->format('d/m/Y H:i:s') }}</li>
                                                    <li class="list-group-item">{{ \Carbon\Carbon::parse($cart->updated_at)->format('d/m/Y H:i:s') }}</li>
                                                    <li class="list-group-item" @switch($cart->status->status)
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
                                                        @endswitch>{{ $cart->status->status }}</li>
                                                </b>
                                            </div>
                                        </div>

                                    </ul>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 text-center"><a href="{{ url('/order/' . $cart->id) }}" target="_blank" class="card-link" style="color: #3c8486d6; font-weight:bold;"> VER PEDIDO </a></div>

                                            <div class="col-sm-6 text-center"><a href="{{ url('/contact') }}" class="card-link" style="color: #3c8486d6; font-weight:bold;"> CONTACTAR ADMIN </a></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach
                    </div>

                </div>

                <div @if (Request::url()==route('settings')) class='tab-pane active' @else class='tab-pane' @endif id="{{ url('/home/settings') }}">
                    <h3 class="title text-center">Datos del usuario {{ Auth()->user()->name }}</h3>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>
                                {{$error}}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (session('updateUserData'))
                    <div class="alert alert-success" role="alert">
                        {{ session('updateUserData') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">
                        <ul>
                            {{ session('error') }}
                        </ul>
                    </div>
                    @endif

                    <form method="post" action="{{ url('/home/') }}">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4  offset-sm-2">
                                <label for="inputUserName">Nombre de Usuario</label>
                                <input type="text" class="form-control" name="username" id="inputUserName" value="{{ old('username', Auth()->user()->name) }}" placeholder="Nombre de Usuario" onkeypress="isNotNumber(event);" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password">Contraseña Actual</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 offset-sm-2">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', Auth()->user()->email) }}" placeholder="Correo Electrónico" required autocomplete="email">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="newPassword">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="new-password" id="newPassword" placeholder="Nueva Contraseña">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 offset-sm-2">
                                <div class="form-group">
                                    <label class="form-check-label" for="email-confirmed">
                                        @if(Auth()->user()->email_verified_at)
                                        <b style="color:green;"><u>Correo electrónico confirmado el {{ \Carbon\Carbon::parse(Auth()->user()->email_verified_at)->format('d/m/Y H:i:s') }}</u></b>
                                        @else
                                        <b style="color:red;">Correo electrónico sin confirmar, por favor revisar su cuenta de correo.</b>
                                        @endif
                                    </label>

                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cNewPassword">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" name="new-password_confirmation" id="cNewPassword" placeholder="Confirmar Nueva Contraseña">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 offset-sm-2">
                                <label for="phone">N° Teléfono</label>
                                <input type="phone" class="form-control" name="phone" id="phone" value="{{ old('phone', Auth()->user()->phone) }}" placeholder="2625225566" onkeypress="isNumber2(event);">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 offset-sm-2">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" name="address" id="address" value="{{ old('address', Auth()->user()->address) }}" placeholder="Av. Alvear Oeste n° 1245 - B° Islas Malvinas">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalOrder" tabindex="-1" role="dialog" aria-labelledby="modalOrderHeader" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if(auth()->user()->address)
            <div class="modal-header">
                <h5 class="modal-title" id="modalOrderHeader"><b>Verifique los datos del pedido #{{auth()->user()->cart->id}}</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" action="{{ url('/order') }}">
                @csrf


                <div class="modal-body">
                    <h6>Detalles:</h6>
                    <p>El pedido será enviado a la direccion: <b>{{ auth()->user()->address }}</b>, a nombre de <b>{{auth()->user()->name}}</b>.<br>
                        Para contactarnos con usted se utilizará:</p>
                    <ul style="font-size: 14px;">
                        <li>Teléfono: <b>{{auth()->user()->phone}}</b></li>
                        <li>Email: <b>{{auth()->user()->email}}</b></li>
                    </ul>
                    <p style="font-size: 11px;">Para cambiar cualquiera de éstos datos, por favor dirijase a la seccion de configuración o bien, pongase en contacto con el administrador.</p>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Confirmar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
            @else
            <div class="modal-header">
                <h5 class="modal-title" id="modalOrderHeader"><b>Datos faltantes</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="border-radius: 0.3rem;">
                    <h4>Por favor, termine de configurar sus datos de usuario en la pestaña de Configuraciones antes de proceder.</h4>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@include('includes.footer')
@endsection
@section('js_scripts')
<script>
    // this prevents from typing non-number text, including "e".
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    // this prevents from typing non-number text, including "e" and ".".
    function isNumber2(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) || charCode == 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    // this prevents from typing non-number text, including "e".
    function isNotNumber(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            return true;
        } else {
            evt.preventDefault();
        }
    }

    function calcular(cantidad, id) {
        var total = 0;
        total = parseFloat(document.getElementById('total_id').innerHTML);
        total -= parseFloat(document.getElementById('sub_total' + id).innerHTML);

        var price = 0;
        price = parseFloat(document.getElementById('price_id' + id).innerHTML);

        cantidad = parseInt(cantidad); // Convertir el valor a un entero (número).   

        /* Esta es la cuenta. */
        var subTotal = 0;
        subTotal = (price * cantidad);
        total += subTotal;

        // Colocar el resultado de la cuenta en el control "span".
        document.getElementById('quantity_id' + id).innerHTML = cantidad;
        document.getElementById('sub_total' + id).innerHTML = subTotal.toFixed(2);
        document.getElementById('total_id').innerHTML = total.toFixed(2);
    }
</script>
@endsection