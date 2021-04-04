<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="{{asset('img/alventa_icon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title> @yield('tittle', 'AlVenta, tu lugar de intercambios')

  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">


  <!-- CSS Files -->
  <link href="{{asset('css/material-kit.css?v=2.0.7')}}" rel="stylesheet" />
  <!-- <link href="{{secure_asset('css/material-kit.css?v=2.0.7')}}" rel="stylesheet" /> -->

  @yield('cssFiles')

  <!--Estilos del buscador-->
  <style>
    .btn_ctm {
      padding: 5px 5px;
    }

    .tt-query {
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    }

    .tt-hint {
      color: #999
    }

    .tt-menu {
      /* used to be tt-dropdown-menu in older versions */
      width: 345px;
      margin-top: 4px;
      padding: 4px 0;
      background-color: #fff;
      border: 1px solid #ccc;
      border: 1px solid rgba(0, 0, 0, 0.2);
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
      -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
      box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
    }

    .tt-suggestion {
      padding: 3px 20px;
      line-height: 24px;
    }

    .tt-suggestion.tt-cursor,
    .tt-suggestion:hover {
      color: #fff;
      background-color: #0097cf;

    }

    .tt-suggestion p {
      margin: 0;
    }

    #lblCartCount {
      font-size: 15px;
      background: #ff0000;
      color: #fff;
      padding: 0 5px;
      vertical-align: top;
      margin-left: -4px;
    }

    .badge {
      padding-left: 9px;
      padding-right: 9px;
      -webkit-border-radius: 9px;
      -moz-border-radius: 9px;
      border-radius: 9px;
      margin-top: -17px;
    }

    .label-warning[href],
    .badge-warning[href] {
      background-color: #c67605;
    }
  </style>
  <!--Estilos de Welcome.Blade.php-->
  @yield('styles')
  @livewireStyles
</head>

<body class="@yield('body-class')">
  <?php

  use App\Category;
  //El metodo HAS es un SQL JOIN en donde se establece que busque las categorias que tengan productos
  $categories = Category::has('products')->orderBy('name')->get();
  ?>

  <nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="navbar-translate">
      <a class="navbar-brand" href="{{url('/')}}">
        <img src="{{ asset('img\alventa_logo.png') }}" height="50">
      </a>
      <!--Por medio del metodo config('app.name') obtenemos el nombre de la aplicacion que esta en el archivo .env-->
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon"></span>
        <span class="navbar-toggler-icon"></span>
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <!--Categorias-->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">
        <a id="navbarDropdownCategories" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          Categorías <span class="caret"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownCategories">
          @foreach($categories as $category)
          <a class="dropdown-item" href="{{ url('/categories/' . $category->id) }}" target="_blank">{{ $category->name }}</a>
          @endforeach
        </div>
      </li>
    </ul>


    <!--BUSCADOR CENTRAL-->
    <div class="col-sm-4 hide">
      <form method="get" action="{{ url('/search') }}" target="_blank">

        <div class="input-group">
          <span class="input-group-addon">
            <i class="material-icons" style="color: white;">search</i>
          </span>
          <input type="text" class="form-control text-center" placeholder="¿QUÉ PRODUCTO BUSCAS?" name="query" id="search" style="height: 2em; background-image: linear-gradient(to top, #37bdb2 4px, rgba(156, 39, 176, 0) 2px), linear-gradient(to top, #d2d2d2 1px, rgba(210, 210, 210, 0) 1px); width: 20em; background-color: white; border-radius: 20em;">
          <button type="submit" class="btn btn_ctm btn-link" style="color: white; border-color:white; border:solid; border-radius:20em;">Buscar</button>
        </div>

      </form>
    </div>

    <div class="collapse navbar-collapse">
      <i class="fa ml-auto" style="font-size:35px; color:white;"><a href="{{ url('/home/cart') }}" style="color: white;">&#xf07a;</a></i>
      <span class='badge badge-warning' id='lblCartCount'> {{Auth::user() ? Auth::user()->cart->details->count() : '0'}} </span>

      <ul class="navbar-nav">
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}" style="padding-left: 1.5rem;">{{ __('Ingresar') }}</a>
        </li>
        @if (Route::has('register'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
        </li>
        @endif
        @else

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

            <a class="dropdown-item" href="{{ url('/home/dashboard') }}">Dashboard</a>

            @if (auth()->user()->rol->id == 1 || auth()->user()->rol->id == 2)
            <a class="dropdown-item" href="{{ url('admin\categories') }}">Gestionar Categorías</a>
            <a class="dropdown-item" href="{{ url('admin\products') }}">Gestionar Productos</a>
            <a class="dropdown-item" href="{{ url('admin\orders') }}">Gestionar Pedidos</a>
            @endif

            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
              {{ __('Cerrar Sesión') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
        @endguest

      </ul>
    </div>
  </nav>

  <div class="wrapper">
    @yield('content')
  </div>

  <!--   Core JS Files   -->
  <script src="{{asset('js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('js/core/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('js/core/bootstrap-material-design')}}.min.js" type="text/javascript"></script>
  <script src="{{asset('js/plugins/moment.min.js')}}"></script>
  <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="{{asset('js/plugins/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="{{asset('js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
  <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('js/material-kit.js?v=2.0.7')}}" type="text/javascript"></script>


  <!--PARA EL BUSCADOR PREDICTIVO-->
  <!--	Plugin para el buscador predictivo -->
  <script src="{{asset('js\plugins\typeahead.bundle.min.js')}}" type="text/javascript"></script>

  <!--Ahora hay que inicializar el script sobre el INPUT con ID search-->
  <script>
    $(function() {

      //Se debe inicializar el elemento que se pasa como parametro PRODUCTS que viene a ser la fuente SOURCE (CODIGO COPIADO DESDE EL EJEMPLO PORQUE UTILIZA EL MOTOR DE BUSQUEDA)
      var products = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        //Se define un arreglo si queremos una busqueda acotada en determinados elementos
        //local: ['hola', 'prueba1', 'prueba2', 'abcdwq']

        //Como se quiere utilizar una lista de productos que va a cambiar constantemente, se define un objeto JSON y se usa el atributo PREFETCH.
        //Como usamos una base de datos, vamos a generar un objeto JSON a partir de los productos registrados. Es una ruta VER WEB.PHP
        prefetch: '{{ url("/products/json") }}'
      });

      //Se selecciona el objeto con ID SEARCH y se le pasan 2 objetos por parametro.
      $('#search').typeahead({
        hint: false,
        highlight: true,
        minLength: 1
      }, {
        name: 'products',
        source: products
      });
    });
  </script>
  
  @yield('js_scripts')
  @livewireScripts
</body>

</html>