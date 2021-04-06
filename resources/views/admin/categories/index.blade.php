@extends('layouts.app')

@section ('tittle', 'Listado de Categorías')

@section ('body-class', 'profile-page sidebar-collapse')

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce4.jpg')}}')">
</div>

<div class="main main-raised">

  <div class="container">

    <div class="section text-center">
      <h2 class="title">Listado de Categorías</h2>

      @if (session('updatedCategory'))
      <div class="alert alert-success" role="alert">
        {{ session('updatedCategory') }}
      </div>
      @endif

      @if (session('error'))
      <div class="alert alert-danger">
        <ul>
          {{ session('error') }}
        </ul>
      </div>
      @endif

      <div class="team">

        <div>
          <!--Por medio del objeto que viene con los datos de la base de datos, generamos los links para las paginas-->
          {{ $categories -> links()}}
        </div>

        <a href="{{url('/admin/categories/create')}}" class="btn btn-primary btn-round">Agregar Categoría</a>

        <div class="row">
          <table class="table">
            <thead>

              <tr>
                <th class="text-center">#</th>
                <th class="col-auto">Nombre</th>
                <th class="col-auto">Descripción</th>
                <th>Imagen</th>
                <th class="text-center">Opciones</th>
              </tr>

            </thead>

            <tbody>
              @foreach ($categories as $category)
              <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->description}}</td>
                <td><img src="{{ $category->featured_image_url }}" height="50"></td>
                <td class="td-actions text-center">

                  <!--<form method="post" action="{{ url('/admin/categories/'.$category->id) }}">
                    @csrf
                    @method('DELETE')-->
                  <!--<input type="hidden" name="_method" value="DELETE">
                    el @method('DELETE') es equivalente al INPUT HIDDEN-->

                  <a href="{{ url('/admin/categories/'.$category->id.'/edit') }}" rel="tooltip" data-placement="right" title="Editar Categoría" class="btn btn-success btn-simple btn-xs">
                    <i class="fa fa-edit"></i>
                  </a>

                  <button type="button" rel="tooltip" data-toggle="modal" data-target="#modalCategory" data-placement="right" title="Eliminar Categoría" class="btn btn-danger btn-simple btn-xs" onclick="setCatId('{{ $category->id }}')">
                    <i class="fa fa-times"></i>
                  </button>
                  <!--</form>-->

                </td>
              </tr>
              @endforeach
            </tbody>

          </table>

        </div>

        <div>
          <!--Por medio del objeto que viene con los datos de la base de datos, generamos los links para las paginas-->
          {{ $categories -> links()}}
        </div>

      </div>
    </div>

  </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="modalCategoryHeader" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalCategoryHeader"><b>Confirme la acción</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" action="{{ url('/admin/categories/delete') }}">
        @csrf
        <input type="hidden" name="categoryID" id="catId">
        <div class="modal-body">
          <h4 class="text-center">¿Está seguro que desea eliminar la categoría?</h4>
          <p class="text-center"><b>Asegurese de que no hayan productos activos dentro de dicha categoría.</b></p>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Confirmar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

@include('includes.footer')

<script>
  function setCatId($id) {
    document.getElementById("catId").value = $id;
  }
</script>

@endsection