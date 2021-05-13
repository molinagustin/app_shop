@extends('layouts.app')

@section ('tittle', 'Bienvenido a ' . config('app.name'))

@section ('body-class', 'landing-page sidebar-collapse')

@section ('styles')
<!--Para las veces que haga falta podemos cargar estilos desde una seccion y se aplicaran en APP.blade-->
<style>
  .links-paginate {
    display: inline-block;
  }
  
  .product-name {
    margin-bottom: 0em;
  }
</style>
@endsection

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce2.jpg')}}')">


  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-sm-1">
        <h1 class="title">{{ config('app.name') }}</h1>
        <h4>Compra Venta de nuevos y usados en General Alvear</h4>
        <br>
        <a href="#" class="btn btn-danger btn-raised btn-lg">
          <i class="fa fa-play"></i> ¿Cómo Funciona?
        </a>
      </div>
    </div>
  </div>


</div>

<div class="main main-raised">


  <div class="container">
    <div class="section text-center">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <h2 class="title">¿Por qué AlVenta?</h2>

          <h5 class="description">Porque facilita tus compras a los comercios locales, unificando en un solo sitio todo aquello que quieres vender, comprar u ofrecer, dejando de
            visitar cientos de grupos distintos. </h5>
        </div>
      </div>
      <div class="features">
        <div class="row">
          <div class="col-md-4">
            <div class="info">
              <div class="icon icon-info">
                <i class="material-icons">chat</i>
              </div>
              <h4 class="info-title">Pregúntanos</h4>
              <p>Cualquier duda que tengas, está disponible nuestro chat o formulario de contacto. Nuestros agentes están disponibles las 24 horas.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info">
              <div class="icon icon-success">
                <i class="material-icons">verified_user</i>
              </div>
              <h4 class="info-title">Pago Seguro</h4>
              <p>Usamos Mercado Pago como plataforma de pago, por lo que tus transacciones cuentan con un alto nivel de seguridad y respaldo. Si no
                confías en los pagos online, puedes acordar con el vendedor y pagar al momento de recibir el producto.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info">
              <div class="icon icon-danger">
                <i class="material-icons">fingerprint</i>
              </div>
              <h4 class="info-title">Información Privada</h4>
              <p>Los pedidos que realices solo los conocerás tú y tu vendedor. Nadie más tiene acceso a esta información.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section text-center">

      <h2 class="title">Puede que te interese alguno de éstos productos</h2>
      <br>
      <div id="carouselIndicators" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">
          <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselIndicators" data-slide-to="1"></li>
          <li data-target="#carouselIndicators" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="{{ $products[0]->featured_image_url }}" alt="First slide" height="400" width="500">
            <div class="carousel-caption d-none d-md-block">
              <h5 class="product-name btn btn-info btn-round btn-sm"><a href="{{ url('/products/' . $products[0]->id) }}" style="color: white;">{{ $products[0]->name }}</a></h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{ $products[1]->featured_image_url }}" alt="Second slide" height="400" width="500">
            <div class="carousel-caption d-none d-md-block">
              <h5 class="product-name btn btn-info btn-round btn-sm"><a href="{{ url('/products/' . $products[1]->id) }}" style="color: white;">{{ $products[1]->name }}</a></h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{ $products[2]->featured_image_url }}" alt="Third slide" height="400" width="500">
            <div class="carousel-caption d-none d-md-block">
              <h5 class="product-name btn btn-info btn-round btn-sm"><a href="{{ url('/products/' . $products[2]->id) }}" style="color: white;">{{ $products[2]->name }}</a></h5>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <h4>O revisa nuestras <a class="btn-link" href="{{ url('/categories') }}">categorías</a></h4>

    </div>

    <div class="section section-contacts">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <h2 class="text-center title">¿Todavía no te has registrado? Es muy simple.</h2>
          <h4 class="text-center description">Solo necesitamos unos pocos datos y tendrás tu usuario listo.</h4>

          <form class="contact-form" method="get" action="/register">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Nombre</label>
                  <input type="text" class="form-control" name="name" onkeypress="isNotNumber(event);">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Correo Electrónico</label>
                  <input type="email" class="form-control" name="email">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 ml-auto mr-auto text-center">
                <button type="submit" class="btn btn-primary btn-raised">
                  Iniciar Registro
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>


</div>

@include('includes.footer')

@endsection
<script>
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
</script>