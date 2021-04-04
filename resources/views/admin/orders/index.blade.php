@extends('layouts.app')

@section ('tittle', 'Listado de Pedidos')

@section ('body-class', 'profile-page sidebar-collapse')

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce2.jpg')}}')">
</div>

<div class="main main-raised">


  <div class="container">

    <div class="section text-center">
      <h2 class="title">Listado de Pedidos</h2>

      <div class="team">

        <div>
          <!--Por medio del objeto que viene con los datos de la base de datos, generamos los links para las paginas-->
          <!--Paginacion-->
          {{ $carts->links() }}
        </div>

        <div class="row">
          <table class="table">
            <thead>

              <tr>
                <th class="text-center"># Orden</th>
                <th class="col-auto">Fecha Pedido</th>
                <th class="col-auto">Estado</th>
                <th>Usuario</th>
                <th class="text-center">Email</th>
                <th class="text-center"># Tipos Productos</th>
                <th class="text-center">Opciones</th>
              </tr>

            </thead>

            <tbody>
              @foreach ($carts as $cart)
              <tr>
                <td>{{$cart->id}}</td>
                <td>{{ \Carbon\Carbon::parse($cart->order_date)->format('d/m/Y H:i:s') }}</td>
                <td @switch($cart->status->status)
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
                  @endswitch>{{$cart->status->status}}</td>
                <td>{{$cart->user->name}}</td>
                <td>{{$cart->user->email}}</td>
                <td>{{$cart->details->count()}}</td>
                <td class="td-actions text-center">
                  <a href="{{ url('admin/orders/' . $cart->id) }}" rel="tooltip" data-placement="right" title="Ver Detalles" class="btn btn-info btn-simple btn-xs">
                    <i class="fa fa-info-circle"></i>
                  </a>                  
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>

        </div>

        <div>
          <!--Paginacion-->
          {{ $carts->links() }}
        </div>

      </div>
    </div>

  </div>


</div>


@include('includes.footer')

@endsection