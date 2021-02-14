@extends('layouts.app')

@section ('tittle', 'Listado de Productos')

@section ('body-class', 'profile-page sidebar-collapse')

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce2.jpg')}}')">
</div>

<div class="main main-raised">


  <div class="container">

    <div class="section text-center">
      <h2 class="title">Listado de Productos</h2>

      <div class="team">

        <div>
          <!--Por medio del objeto que viene con los datos de la base de datos, generamos los links para las paginas-->
          {{ $products -> links()}}
        </div>

        <a href="{{url('/admin/products/create')}}" class="btn btn-primary btn-round">Agregar Producto</a>

        <div class="row">
          <table class="table">
            <thead>

              <tr>
                <th class="text-center">Imagen</th>
                <th>Nombre</th>
                <th class="col-auto">Descripción</th>
                <th>Categoría</th>
                <th class="text-right">Precio</th>
                <th class="text-center">Opciones</th>
              </tr>

            </thead>

            <tbody>
              @foreach ($products as $product)
              <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->description}}</td>
                <!--Usamos el operador ternario ? : lo que indica que si existe una categoria en el producto, se mostrara si nombre
                y en caso de que no haya una se mostrara la palabra General-->
                <td>{{$product->category ? $product->category->name : 'General'}}</td>
                <td class="text-right">&dollar; {{$product->price}}</td>
                <td class="td-actions text-center">

                  <form method="post" action="{{ url('/admin/products/'.$product->id) }}">
                    @csrf
                    @method('DELETE')
                    <!--<input type="hidden" name="_method" value="DELETE">
                    el @method('DELETE') es equivalente al INPUT HIDDEN-->

                    <a href="" rel="tooltip" data-placement="right" title="Ver Detalles" class="btn btn-info btn-simple btn-xs">
                      <i class="fa fa-info-circle"></i>
                    </a>
                    <a href="{{ url('/admin/products/'.$product->id.'/edit') }}" rel="tooltip" data-placement="right" title="Editar" class="btn btn-success btn-simple btn-xs">
                      <i class="fa fa-edit"></i>
                    </a>

                    <button type="submit" rel="tooltip" data-placement="right" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                      <i class="fa fa-times"></i>
                    </button>
                  </form>
                  
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>

        </div>

        <div>
          <!--Por medio del objeto que viene con los datos de la base de datos, generamos los links para las paginas-->
          {{ $products -> links()}}
        </div>

      </div>
    </div>

  </div>


</div>


<footer class="footer footer-default">
  <div class="container">
    <nav class="float-left">
      <ul>
        <li>
          <a href="https://www.creative-tim.com/">
            Creative Tim
          </a>
        </li>
        <li>
          <a href="https://www.creative-tim.com/presentation">
            About Us
          </a>
        </li>
        <li>
          <a href="https://www.creative-tim.com/blog">
            Blog
          </a>
        </li>
        <li>
          <a href="https://www.creative-tim.com/license">
            Licenses
          </a>
        </li>
      </ul>
    </nav>
    <div class="copyright float-right">
      &copy;
      <script>
        document.write(new Date().getFullYear())
      </script>, made with <i class="material-icons">favorite</i> by
      <a href="https://www.creative-tim.com/" target="_blank">Creative Tim</a> for a better web.
    </div>
  </div>
</footer>
@endsection